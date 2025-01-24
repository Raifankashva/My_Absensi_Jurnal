<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\DataSiswa;
use App\Observers\DataSiswaObserver;

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
    DataSiswa::observe(DataSiswaObserver::class);
}
}
