<?php

namespace App\Providers;

use App\Http\View\Composers\MasterComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        // Using class based composers...
        View::composer('backend.inc_sidebar', MasterComposer::class);

        // // Using closure based composers...
        // View::composer('dashboard', function ($view) {
        //     //
        //     dd($view);
        // });
    }
}
