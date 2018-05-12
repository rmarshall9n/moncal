<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\UpdateBalanceWidgetComposer;
use App\Http\ViewComposers\CurrentBalanceWidgetComposer;
use App\Http\ViewComposers\UpcomingBalanceWidgetComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer('widgets.update-balance', UpdateBalanceWidgetComposer::class);
        View::composer('widgets.current-balance', CurrentBalanceWidgetComposer::class);
        View::composer('widgets.upcoming-balance', UpcomingBalanceWidgetComposer::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}