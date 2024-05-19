<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Event;
use App\Models\Hall;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class EventsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    protected function getCards(): array
    {
        return [
            Card::make('Total Hall Bookings', Event::count()),
            Card::make('Total Halls', Hall::count()),
            Card::make('Total Approved Bookings', Event::where('status', 1)->count()),
            Card::make('Total Rejected Bookings', Event::where('status', 2)->count()),
        ];
    }
}
