<?php

namespace App\Filament\Cp\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;

class MyWorkshops extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.my-workshops';

    public static function getNavigationGroup(): ?string
    {
        return   __('workshops');
    }

    public function getTitle(): string
    {
        return   __('my_workshops');
    }

    public static function getNavigationLabel(): string
    {
        return   __('my_workshops');
    }
}
