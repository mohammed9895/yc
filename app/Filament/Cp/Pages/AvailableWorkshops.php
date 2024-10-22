<?php

namespace App\Filament\Cp\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;

class AvailableWorkshops extends Page
{

//    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static string $view = 'filament.pages.available-workshops';

    public static function getNavigationGroup(): ?string
    {
        return   __('workshops');
    }

    public function getTitle(): string
    {
        return   __('filament::yc.available-workshops');
    }

    public static function getNavigationLabel(): string
    {
        return   __('filament::yc.available-workshops');
    }

}
