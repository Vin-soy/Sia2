<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Transaction;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('landlord.layouts.nav', function ($view) {
            if (auth()->check() && auth()->user()->role === 'landlord') {
                $pendingApplications = Transaction::whereHas('rental', function($query) {
                    $query->where('landlord_id', auth()->id());
                })->where('status', 'pending')->count();

                $view->with('pendingApplications', $pendingApplications);
            }
        });
    }
}
