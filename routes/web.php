<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ProfileController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('rentals', RentalController::class);
});

Route::middleware(['auth', 'role:tenant'])->group(function () {
    Route::get('tenant/home', function () {
        return view('tenant.layouts.home');
    })->name('tenant.home');

    Route::get('tenant/account', function () {
        return view('tenant.layouts.account');
    })->name('tenant.account');

    Route::get('tenant/history', function () {
        return view('tenant.layouts.history');
    })->name('tenant.history');
});

Route::middleware(['auth', 'role:landlord'])->group(function () {
    Route::get('landlord/home', function () {
        return view('landlord.layouts.home');
    })->name('landlord.home');

    Route::get('landlord/account', function () {
        return view('landlord.layouts.account');
    })->name('landlord.account');

    Route::get('tenant/history', function () {
        return view('landlord.layouts.history');
    })->name('landlord.history');
});



Route::get('/', function () {
    return view('landing-page');
});

Route::get('/home', function () {
    return view('admin.index');
})->name('home');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
