<?php

namespace Asmi046\MobileMenu;

use Asmi046\MobileMenu\View\Components\MobileMenu;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MobileMenuServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mobile-menu');

        Blade::component('mobile-menu', MobileMenu::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/scss' => resource_path('scss/vendor/mobile-menu'),
            ], 'mobile-menu-scss');

            $this->publishes([
                __DIR__.'/../resources/js' => resource_path('js/vendor/mobile-menu'),
            ], 'mobile-menu-js');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/mobile-menu'),
            ], 'mobile-menu-views');
        }
    }
}
