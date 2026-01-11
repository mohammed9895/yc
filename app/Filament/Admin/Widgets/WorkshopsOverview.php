<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Booking;
use App\Models\Slot;
use App\Models\Workshop;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class WorkshopsOverview extends BaseWidget
{
    protected static ?int $sort = 3;

    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    protected function getCards(): array
    {
        return [
            Stat::make('Total Workshops', Workshop::count()),
            Stat::make('Total Slots', Slot::count()),
            Stat::make('Total Bookings', Booking::count()),
        ];
    }

    public function getFilters(): array
    {
        return [
            'T' => __('filament-google-analytics::widgets.T'),
            'TW' => __('filament-google-analytics::widgets.TW'),
            'TM' => __('filament-google-analytics::widgets.TM'),
            'TY' => __('filament-google-analytics::widgets.TY'),
        ];
    }
}
