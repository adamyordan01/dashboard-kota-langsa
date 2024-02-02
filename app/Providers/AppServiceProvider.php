<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
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
        View::composer('*', function ($view) {
            $privateMenu = Cache::rememberForever('private-menu', function () {
                return Menu::with('submenus')
                    ->where('is_public', false)
                    ->orderBy('order', 'asc')
                    ->get();
            });

            $publicMenu = Cache::rememberForever('public-menu', function () {
                return Menu::with('submenus')
                    ->where('is_public', true)
                    ->orderBy('order', 'asc')
                    ->get();
            });

            $view->with('privateMenu', $privateMenu);
            $view->with('publicMenu', $publicMenu);
        });
    }
}
