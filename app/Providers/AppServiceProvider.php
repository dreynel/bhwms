<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\GeoCalculatorInterface;
use App\Services\GeoLocationService;
use App\Contracts\HouseholdRepositoryInterface;
use App\Repositories\HouseholdRepository;
use App\Contracts\ResidentRepositoryInterface;
use App\Repositories\ResidentRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register IoC Container Interface Bindings (OOP Principle: Dependency Inversion)
     */
    public function register(): void
    {
        $this->app->bind(GeoCalculatorInterface::class, GeoLocationService::class);
        $this->app->bind(HouseholdRepositoryInterface::class, HouseholdRepository::class);
        $this->app->bind(ResidentRepositoryInterface::class, ResidentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
