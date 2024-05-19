<?php

namespace App\Filament\Cp\Pages;

use App\Filament\Admin\Widgets\AttendessOverview;
use App\Filament\Admin\Widgets\BookingsChart;
use App\Filament\Admin\Widgets\EventsOverview;
use App\Filament\Admin\Widgets\HallBookingChart;
use App\Filament\Admin\Widgets\LatestEvents;
use App\Filament\Admin\Widgets\User\WorkshopsCard;
use App\Filament\Admin\Widgets\UsersChart;
use App\Filament\Admin\Widgets\UsersOverview;
use App\Filament\Admin\Widgets\WorkshopsOverview;
use App\Filament\Widgets\HallBookingsChart;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    // use HasPageShield;

    protected static string $view = 'filament.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            WorkshopsCard::class,
            UsersOverview::class,
            UsersChart::class,
            WorkshopsOverview::class,
            BookingsChart::class,
            EventsOverview::class,
            HallBookingChart::class,
            LatestEvents::class,
            AttendessOverview::class,
        ];
    }


    public function getHeading(): string
    {
        $name = auth()->user()->name;
        return "{$name}'s Dashboard";
    }
}
