<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Event;
use App\Models\Hall;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class EventsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    protected function getCards(): array
    {
        return [
            Stat::make('Total Hall Bookings', Event::count()),
            Stat::make('Total Halls', Hall::count()),
            Stat::make('Total Approved Bookings', Event::where('status', 1)->count()),
            Stat::make('Total Rejected Bookings', Event::where('status', 2)->count()),
        ];
    }
}
