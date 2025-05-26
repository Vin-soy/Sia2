<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'home'])->name('home');
Route::get('/about', [DashboardController::class, 'about'])->name('about');
Route::get('/sample', [DashboardController::class, 'sample'])->name('sample');
Route::get('/contact', [DashboardController::class, 'contact'])->name('contact');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('admin/users', UserController::class);
    Route::resource('admin/rentals', RentalController::class);
    Route::get('admin/profile', [ProfileController::class, 'index'])->name('admin.profile');
});

Route::middleware(['auth', 'role:tenant'])->group(function () {
    Route::get('tenant/home', function () {
        return view('tenant.layouts.home');
    })->name('tenant.home');

    Route::get('tenant/account', function () {
        return view('tenant.layouts.account');
    })->name('tenant.account');

    Route::post('/rental/apply', [RentalController::class, 'apply'])->name('rental.apply');

    Route::get('tenant/rental/{id}', [RentalController::class, 'show'])->name('tenant.rental.show');
    Route::get('tenant/profile',[ProfileController::class, 'index'])->name('tenant.profile');
    Route::get('tenant/history', [RentalController::class, 'index'])->name('tenant.history');
});

Route::middleware(['auth', 'role:landlord'])->group(function () {

    Route::post('landlord/account', [RentalController::class, 'store'])->name('landlord.account.store');
    Route::get('landlord/home', function () {
        return view('landlord.layouts.home');
    })->name('landlord.home');
    Route::resource('landlord/rentals', RentalController::class)->except('index');
    Route::get('landlord/account', [RentalController::class, 'create'])->name('landlord.account');
    Route::get('landlord/history', [RentalController::class, 'landlordRentals'])->name('landlord.history');
    Route::get('landlord/profile',[ProfileController::class, 'index'])->name('landlord.profile');
});





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';