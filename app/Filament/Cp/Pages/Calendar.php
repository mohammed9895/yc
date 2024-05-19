<?php

namespace App\Filament\Cp\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;

class Calendar extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'filament.pages.calendar';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return   __('filament::yc.calendar');
    }

    public static function getNavigationLabel(): string
    {
        return   __('filament::yc.calendar');
    }
}
