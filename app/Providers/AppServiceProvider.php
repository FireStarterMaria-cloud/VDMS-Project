<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Vehicle;
use App\Models\Sale;
use App\Models\Customer;
use App\Observers\VehicleObserver;
use App\Observers\SaleObserver;
use App\Observers\CustomerObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrap();

        Vehicle::observe(VehicleObserver::class);
        Sale::observe(SaleObserver::class);
        Customer::observe(CustomerObserver::class);
    }
}