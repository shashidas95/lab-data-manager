<?php

namespace App\Providers;

use App\Models\LabSample;
use App\Observers\LabSampleObserver;
use Illuminate\Support\ServiceProvider;

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
        LabSample::observe(LabSampleObserver::class);
    }
}
