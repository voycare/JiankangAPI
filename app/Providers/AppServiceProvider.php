<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $this->app['validator']->extend('array_numeric', function ($attribute, $value, $parameters) {
            foreach ($value as $v) {
                if (!is_int($v)) {
                    return false;
                }
            }
            return true;
        });
    }
}
