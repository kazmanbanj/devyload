<?php

namespace App\Providers;

use App\Models\Channel;
use Barryvdh\Debugbar\ServiceProvider as BarryvdhServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use YlsIdeas\FeatureFlags\Facades\Features;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(BarryvdhServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        view()->composer('*', function ($view) {
            // $channels = Cache::rememberForever('channels', function () {
            //     return Channel::all();
            // });

            $channels = Channel::all();

            $view->with('channels', $channels);
        });

        Validator::extend('spamfree', 'App\Rules\SpamFree@passes');

        Features::noBlade();
        Features::noScheduling();
        Features::noValidations();
        Features::noCommands();
    }
}
