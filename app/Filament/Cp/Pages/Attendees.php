<?php

namespace App\Filament\Cp\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;

class Attendees extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.attendees';

    public static function getNavigationGroup(): ?string
    {
        return __('workshops');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament::attendees.heading');
    }

    public function getTitle(): string
    {
        return __('filament::attendees.heading');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
