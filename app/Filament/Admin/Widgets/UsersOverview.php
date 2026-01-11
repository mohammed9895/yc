<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UsersOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    protected static function filters(): array
    {
        return [
            '5' => __('filament-google-analytics::widgets.FD'),
            '10' => __('filament-google-analytics::widgets.TD'),
            '15' => __('filament-google-analytics::widgets.FFD'),
        ];
    }

    protected function getCards(): array
    {
        $averageAge = User::selectRaw('AVG(TIMESTAMPDIFF(YEAR, birth_date, CURDATE())) as average_age')->value('average_age');
        return [
            Stat::make('Total Users', User::count()),
            Stat::make('Users Registered Today', User::whereDate('created_at', today())->count()),
            Stat::make('Users Registered This Month', User::whereMonth('created_at', '=', date('m'))->count()),
            Stat::make('Male Users', User::where('gender', '=', 0)->count()),
            Stat::make('Female Users', User::where('gender', '=', 1)->count()),
            Stat::make('Residents Users', User::where('citizen', '=', 1)->count()),
            Stat::make('Omani Users', User::where('citizen', '=', 0)->count()),
            Stat::make('Average Age', (int)$averageAge),
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            '5' => __('filament-google-analytics::widgets.FD'),
            '10' => __('filament-google-analytics::widgets.TD'),
            '15' => __('filament-google-analytics::widgets.FFD'),
        ];
    }
}
