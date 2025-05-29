<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseImage;
use App\Models\Transaction;
use App\Models\User;
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

    public function show($id)
    {
        $rental = House::with(['images', 'landlord', 'landlord.info', 'applications.tenant'])
            ->findOrFail($id);

        $user = Auth::user();
        $roleName = $user->roles->pluck('role_name')->first();

        // Check if user has permission to view this rental
        if ($roleName === 'landlord' && $rental->landlord_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        switch ($roleName) {
            case 'admin':
                return view('admin.listings.show', compact('rental'));
            case 'landlord':
                return view('landlord.rentals.showRental', compact('rental'));
            case 'tenant':
                return view('tenant.rentals.showRental', compact('rental'));
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

    public function landlordHome()
    {
        $landlordId = auth()->id();
        
        // Get counts for overview cards
        $totalProperties = House::where('landlord_id', $landlordId)->count();
        $availableProperties = House::where('landlord_id', $landlordId)
            ->where('status', 'available')
            ->count();
        $pendingApplications = Transaction::whereHas('rental', function($query) use ($landlordId) {
            $query->where('landlord_id', $landlordId);
        })->where('status', 'pending')->count();
        $activeRentals = House::where('landlord_id', $landlordId)
            ->where('status', 'rented')
            ->count();

        // Get recent applications
        $recentApplications = Transaction::with(['tenant', 'rental'])
            ->whereHas('rental', function($query) use ($landlordId) {
                $query->where('landlord_id', $landlordId);
            })
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('landlord.layouts.home', compact(
            'totalProperties',
            'availableProperties',
            'pendingApplications',
            'activeRentals',
            'recentApplications'
        ));
    }

    public function tenantHome()
    {
        $tenantId = auth()->id();

        // Get active rentals
        $rentals = Transaction::with(['rental.images'])
            ->where('tenant_id', $tenantId)
            ->where('status', 'approved')
            ->get();

        $activeRentals = $rentals->count();

        // Get pending applications
        $pendingApplications = Transaction::where('tenant_id', $tenantId)
            ->where('status', 'pending')
            ->count();

        // Calculate total monthly rent
        $totalMonthlyRent = $rentals->sum('rental.price');

        // Get next payment date (first day of next month for active rentals)
        $nextPaymentDate = $activeRentals > 0 ? now()->addMonth()->startOfMonth()->format('M d, Y') : null;

        // Get recent applications
        $recentApplications = Transaction::with(['rental.images'])
            ->where('tenant_id', $tenantId)
            ->latest()
            ->take(5)
            ->get();

        return view('tenant.layouts.home', compact(
            'rentals',
            'activeRentals',
            'pendingApplications',
            'totalMonthlyRent',
            'nextPaymentDate',
            'recentApplications'
        ));
    }

    public function adminHome()
    {
        // Get overall statistics
        $totalProperties = House::count();
        $availableProperties = House::where('status', 'available')->count();
        $rentedProperties = House::where('status', 'rented')->count();
        $underMaintenanceProperties = House::where('status', 'under_maintenance')->count();

        // Get total landlords and tenants
        $totalLandlords = User::whereHas('roles', function($query) {
            $query->where('role_name', 'landlord');
        })->count();

        $totalTenants = User::whereHas('roles', function($query) {
            $query->where('role_name', 'tenant');
        })->count();

        // Get recent applications
        $recentApplications = Transaction::with(['tenant', 'rental'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Get recent properties
        $recentProperties = House::with(['landlord', 'images'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.layouts.home', compact(
            'totalProperties',
            'availableProperties',
            'rentedProperties',
            'underMaintenanceProperties',
            'totalLandlords',
            'totalTenants',
            'recentApplications',
            'recentProperties'
        ));
    }

    public function reports()
    {
        // Get date range (default to last 30 days)
        $endDate = now();
        $startDate = now()->subDays(30);

        // Calculate total revenue and trend
        $totalRevenue = Transaction::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $previousRevenue = Transaction::where('status', 'completed')
            ->whereBetween('created_at', [$startDate->copy()->subDays(30), $startDate])
            ->sum('total_amount');

        $revenueTrend = $previousRevenue > 0 
            ? (($totalRevenue - $previousRevenue) / $previousRevenue) * 100 
            : 100;

        // Get transaction statistics
        $totalTransactions = Transaction::whereBetween('created_at', [$startDate, $endDate])->count();
        $previousTransactions = Transaction::whereBetween('created_at', [$startDate->copy()->subDays(30), $startDate])->count();
        $transactionsTrend = $previousTransactions > 0 
            ? (($totalTransactions - $previousTransactions) / $previousTransactions) * 100 
            : 100;

        // Calculate occupancy rate
        $totalProperties = House::count();
        $rentedProperties = House::where('status', 'rented')->count();
        $occupancyRate = $totalProperties > 0 ? ($rentedProperties / $totalProperties) * 100 : 0;

        $previousRented = House::where('status', 'rented')
            ->where('updated_at', '<=', $startDate)
            ->count();
        $previousTotal = House::where('updated_at', '<=', $startDate)->count();
        $previousOccupancy = $previousTotal > 0 ? ($previousRented / $previousTotal) * 100 : 0;
        $occupancyTrend = $previousOccupancy > 0 
            ? (($occupancyRate - $previousOccupancy) / $previousOccupancy) * 100 
            : 100;

        // Get new applications count
        $newApplications = Transaction::where('status', 'pending')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $previousApplications = Transaction::where('status', 'pending')
            ->whereBetween('created_at', [$startDate->copy()->subDays(30), $startDate])
            ->count();
        $applicationsTrend = $previousApplications > 0 
            ? (($newApplications - $previousApplications) / $previousApplications) * 100 
            : 100;

        // Get chart data
        $revenueChartLabels = [];
        $revenueChartData = [];
        for ($i = 0; $i < 12; $i++) {
            $month = now()->subMonths($i);
            $revenueChartLabels[] = $month->format('M Y');
            $revenueChartData[] = Transaction::where('status', 'completed')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount');
        }
        $revenueChartLabels = array_reverse($revenueChartLabels);
        $revenueChartData = array_reverse($revenueChartData);

        // Get property performance data
        $propertyChartLabels = House::pluck('address')->take(10)->toArray();
        $propertyChartData = House::withCount(['applications as occupancy_rate' => function($query) {
            $query->where('status', 'approved');
        }])->take(10)->pluck('occupancy_rate')->toArray();

        // Get recent transactions
        $recentTransactions = Transaction::with(['tenant', 'rental'])
            ->latest()
            ->take(5)
            ->get();

        // Get top performing properties
        $topProperties = House::withCount(['applications as total_applications'])
            ->withSum(['applications as total_revenue' => function($query) {
                $query->where('status', 'completed');
            }], 'total_amount')
            ->orderByDesc('total_revenue')
            ->take(5)
            ->get()
            ->map(function($property) {
                $property->occupancy_rate = $property->total_applications > 0 
                    ? ($property->applications()->where('status', 'approved')->count() / $property->total_applications) * 100 
                    : 0;
                $property->trend = rand(-20, 50); // This should be calculated based on historical data
                return $property;
            });

        return view('admin.reports.index', compact(
            'totalRevenue',
            'revenueTrend',
            'totalTransactions',
            'transactionsTrend',
            'occupancyRate',
            'occupancyTrend',
            'newApplications',
            'applicationsTrend',
            'revenueChartLabels',
            'revenueChartData',
            'propertyChartLabels',
            'propertyChartData',
            'recentTransactions',
            'topProperties'
        ));
    }
}
