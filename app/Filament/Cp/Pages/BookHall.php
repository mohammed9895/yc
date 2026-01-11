<?php

namespace App\Filament\Cp\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;

class BookHall extends Page
{
//    use HasPageShield;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';

    protected string $view = 'filament.pages.book-hall';

    public static function getNavigationGroup(): ?string
    {
        return   __('halls');
    }

    public function getTitle(): string
    {
        return   __('filament::yc.book-hall');
    }

    public static function getNavigationLabel(): string
    {
        return   __('filament::yc.book-hall');
    }
}
