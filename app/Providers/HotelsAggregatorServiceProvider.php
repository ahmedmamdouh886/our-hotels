<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\OurHotelsAggregatorInterface as OurHotelsAggregatorInterface;
use App\Services\OurHotelsAggregatorService as OurHotelsAggregatorService;

class HotelsAggregatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OurHotelsAggregatorInterface::class, OurHotelsAggregatorService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
