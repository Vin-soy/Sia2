<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseImage;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    public function index() {
        $user = Auth::user();
        $rentals = House::all();
        $roleName = $user->roles->pluck('role_name')->first();

        switch ($roleName) {
            case 'tenant':
                return view('tenant.layouts.history', compact('rentals'));
            case 'admin':
                return view('admin.listings.index', compact('rentals'));
            case 'landlord':
                return view('landlord.rentals.showRental', compact('rental'));
            default:
                abort(403, 'Unauthorized role.');
        }
    }

    public function create() {
        return view('landlord.layouts.account');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            // Validate the request
            $validated = $request->validate([
                'landlord_id' => 'required|exists:users,id',
                'address' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'number_of_rooms' => 'required|integer|min:1',
                'home_type' => 'required|string|in:apartment,house,studio,duplex,flat',
                'status' => 'required|in:available,rented,under_maintenance',
                'front_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'sub_images' => 'nullable|array|max:4',
                'sub_images.*' => 'image|mimes:jpeg,png,jpg|max:5120',
            ]);

            // Create house
            $rental = House::create([
                'landlord_id' => $validated['landlord_id'],
                'address' => $validated['address'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'number_of_rooms' => $validated['number_of_rooms'],
                'house_type' => $validated['home_type'],
                'status' => $validated['status'],
            ]);

            // Store front image
            if ($request->hasFile('front_image')) {
                $frontImagePath = $request->file('front_image')->store('house_images', 'public');
                
                HouseImage::create([
                    'house_id' => $rental->id,
                    'image_url' => $frontImagePath,
                    'image_order' => 0, // Front image is always first
                    'is_front_image' => true
                ]);
            }

            // Store sub-images
            if ($request->hasFile('sub_images')) {
                foreach ($request->file('sub_images') as $index => $image) {
                    $path = $image->store('house_images', 'public');
                    
                    HouseImage::create([
                        'house_id' => $rental->id,
                        'image_url' => $path,
                        'image_order' => $index + 1, // Sub images start from index 1
                        'is_front_image' => false
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('landlord.history')
                ->with('success', 'Property has been created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete any uploaded images if they exist
            if (isset($frontImagePath)) {
                Storage::disk('public')->delete($frontImagePath);
            }
            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create property. ' . $e->getMessage()]);
        }
    }

    public function show($id) {
        $user = Auth::user();
        $rental = House::with('images')->findOrFail($id);
        $roleName = $user->roles->pluck('role_name')->first();

        switch ($roleName) {
            case 'tenant':
                return view('tenant.rentals.showRental', compact('rental'));
            case 'admin':
                return view('admin.listings.index', compact('rental'));
            case 'landlord':
                return view('landlord.rentals.showRental', compact('rental'));
            default:
                abort(403, 'Unauthorized role.');
        }
    }

    public function edit($id) {
        return view('admin.listings.edit', compact('id'));
    }

    public function update(Request $request, $id) {
        // Implementation here
    }

    public function destroy($id) {
        $rental = House::findOrFail($id);
        
        // Delete associated images from storage
        foreach ($rental->images as $image) {
            Storage::disk('public')->delete($image->image_url);
        }
        
        $rental->delete();

        return redirect()
            ->route('landlord.history')
            ->with('success', 'Property has been deleted successfully.');
    }

    public function landlordRentals() {
        $landlordId = Auth::user();
        $rentals = House::where('landlord_id', $landlordId->id)
            ->with('images')
            ->get();

        return view('landlord.layouts.history', compact('rentals'));
    }

    public function apply(Request $request)
    {
        $request->validate([
            'house_id' => 'required|exists:houses,id',
            'rental_period_start' => 'required|date|after_or_equal:today',
            'rental_period_end' => 'required|date|after:rental_period_start',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $transaction = Transaction::create([
            'tenant_id' => Auth::id(),
            'house_id' => $request->house_id,
            'rental_period_start' => $request->rental_period_start,
            'rental_period_end' => $request->rental_period_end,
            'total_amount' => $request->total_amount,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Rental application submitted successfully.',
            'transaction' => $transaction,
        ]);
    }
}
