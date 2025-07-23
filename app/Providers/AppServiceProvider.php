<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Filament\Facades\Filament;



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

        View::composer('*', function ($view) {
        if (Auth::check()) {
            $notificationsCount = Ticket::where('user_id', Auth::user()->id)
                ->whereNotNull('response')
                ->where('user_read', false)
                ->count();

            $view->with('notificationsCount', $notificationsCount);
        }
        });

     
    }
}