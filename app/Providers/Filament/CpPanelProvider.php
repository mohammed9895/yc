<?php

namespace App\Providers\Filament;

use Filament\Pages\Dashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use App\Filament\Cp\Pages\Auth\Login;
use App\Http\Middleware\VerifyPhone;
use App\Livewire\Auth\Register;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Kenepa\TranslationManager\TranslationManagerPlugin;
use LaraZeus\Bolt\BoltPlugin;

class CpPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('cp')
            ->registration(Register::class)
            ->passwordReset()
            ->login(Login::class)
            ->brandLogo(asset('images/yc-logo-colored.svg'))
            ->path('cp')
            ->colors([
                'primary' => '#4a1d96',
                'gray' => Color::Slate,
            ])
            ->discoverResources(in: app_path('Filament/Cp/Resources'), for: 'App\\Filament\\Cp\\Resources')
            ->discoverPages(in: app_path('Filament/Cp/Pages'), for: 'App\\Filament\\Cp\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Cp/Widgets'), for: 'App\\Filament\\Cp\\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                VerifyPhone::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->viteTheme('resources/css/filament/cp/theme.css')
//            ->plugin(SpatieLaravelTranslatablePlugin::make())
            ->plugin(BoltPlugin::make());
    }
}
