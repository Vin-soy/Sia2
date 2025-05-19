<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseImage;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $validated = $request->validate([
            'landlord_id' => 'required|exists:users,id',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'number_of_rooms' => 'required|integer',
            'home_type' => 'required|string',
            'status' => 'required|in:available,rented,under_maintenance',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

        $storedImages = [];

        // Store images if any
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('house_images', 'public');

                HouseImage::create([
                    'house_id' => $rental->id,
                    'image_url' => $path,
                    'image_order' => $index,
                ]);

                $storedImages[] = $path;
            }
        }

        // Return a JSON response for debugging
        return response()->json([
            'status' => 'success',
            'rental_id' => $rental->id,
            'data_received' => $validated,
            'stored_images' => $storedImages,
        ]);
    }

    
    public function show($id) {
        $user = Auth::user();
        // Show a specific rental property
        $rental = House::findOrFail($id);
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

        return view('landlord.rentals.showRental', compact('rental'));
    }
    public function edit($id) {
        // Edit a specific rental property
        return view('admin.listings.edit', compact('id'));
    } 
    public function update(Request $request, $id) {
        // Validate and update the rental property
        // Redirect or return a response
    }
    public function destroy($id) {
        $rental = House::findOrFail($id);
        $rental->delete();

        return redirect()->route('landlord.history')->with('success', 'User deleted successfully.');
        // Delete a specific rental property
        // Redirect or return a response
    }

    public function landlordRentals() {
        $landlordId = Auth::user();
        $rentals = House::where('landlord_id', $landlordId->id)->get();

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
            'status' => 'pending', // default status
        ]);

        return response()->json([
            'message' => 'Rental application submitted successfully.',
            'transaction' => $transaction,
        ]);
    }
}
