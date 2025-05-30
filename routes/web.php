<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;

// Public routes
Route::get('/', [DashboardController::class, 'home'])->name('home');
Route::get('/about', [DashboardController::class, 'about'])->name('about');
Route::get('/sample', [DashboardController::class, 'sample'])->name('sample');
Route::get('/contact', [DashboardController::class, 'contact'])->name('contact');

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/home', [RentalController::class, 'adminHome'])->name('admin.home');
    Route::resource('admin/users', UserController::class);
    Route::resource('admin/rentals', RentalController::class);
    Route::get('admin/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::get('admin/listings', [RentalController::class, 'index'])->name('admin.listings');
    Route::get('admin/listings/{id}', [RentalController::class, 'show'])->name('admin.listings.show');
    Route::delete('admin/listings/{id}', [RentalController::class, 'destroy'])->name('admin.listings.destroy');
    Route::get('admin/reports', [RentalController::class, 'reports'])->name('admin.reports');
});

// Tenant routes
Route::middleware(['auth', 'role:tenant'])->group(function () {
    // Dashboard and profile
    Route::get('tenant/home', [RentalController::class, 'tenantHome'])->name('tenant.home');
    
    Route::get('tenant/account', [TransactionController::class, 'myApplications'])->name('tenant.account');
    
    Route::get('tenant/profile', [ProfileController::class, 'index'])->name('tenant.profile');
    
    // Rental related
    Route::get('tenant/history', [RentalController::class, 'index'])->name('tenant.history');
    Route::get('tenant/rental/{id}', [RentalController::class, 'show'])->name('tenant.rental.show');
    
    // Transactions
    Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');
    Route::delete('/transaction/{id}/cancel', [TransactionController::class, 'cancel'])->name('transaction.cancel');
});

// Landlord routes
Route::middleware(['auth', 'role:landlord'])->group(function () {
    // Dashboard and profile
    Route::get('landlord/home', [RentalController::class, 'landlordHome'])->name('landlord.home');
    
    Route::get('landlord/profile', [ProfileController::class, 'index'])->name('landlord.profile');
    
    // Notifications and Applications
    Route::get('landlord/notifications', [TransactionController::class, 'landlordApplications'])->name('landlord.notifications');
    Route::post('landlord/applications/{id}/approve', [TransactionController::class, 'approveApplication'])->name('landlord.applications.approve');
    Route::post('landlord/applications/{id}/reject', [TransactionController::class, 'rejectApplication'])->name('landlord.applications.reject');
    
    // Rental management
    Route::get('landlord/account', [RentalController::class, 'create'])->name('landlord.account');
    Route::post('landlord/account', [RentalController::class, 'store'])->name('landlord.account.store');
    Route::get('landlord/history', [RentalController::class, 'landlordRentals'])->name('landlord.history');
    Route::resource('landlord/rentals', RentalController::class)->except('index');
});

// Authentication routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $roleName = $user->roles->pluck('role_name')->first();

        switch ($roleName) {
            case 'tenant':
                return redirect()->route('tenant.home');
            case 'landlord':
                return redirect()->route('landlord.home');
            case 'admin':
                return redirect()->route('admin.home');
            default:
                return redirect()->route('home');
        }
    })->middleware(['verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';