<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\OurHotelsAggregatorInterface as OurHotelsAggregatorInterface;
use App\Services\OurHotelsAggregatorService as OurHotelsAggregatorService;
use App\API\Interfaces\BestHotelsAPIInterface as BestHotelsAPIInterface;
use App\API\BestHotelsAPI as BestHotelsAPI;
use App\API\Interfaces\TopHotelsAPIInterface as TopHotelsAPIInterface;
use App\API\TopHotelsAPI as TopHotelsAPI;

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
        $this->app->bind(BestHotelsAPIInterface::class, BestHotelsAPI::class);
        $this->app->bind(TopHotelsAPIInterface::class, TopHotelsAPI::class);
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
