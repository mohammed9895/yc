<?php

namespace App\Providers;

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
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
        FilamentAsset::register([
            Js::make('app', __DIR__ . '/../../resources/js/app.js')
                ->module(),
            Js::make('picker','https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.umd.min.js')
                ->module(),
            Js::make('picker','https://cdn.jsdelivr.net/npm/@easepick/lock-plugin@1.2.1/dist/index.umd.min.js')
                ->module(),
        ]);
    }
}
