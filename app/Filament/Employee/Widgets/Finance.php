<?php

namespace App\Filament\Employee\Widgets;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Term;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Finance extends BaseWidget
{

    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $income = Income::sum('amount');
        $expenses = Expense::sum('amount');
        $net_income = $income - $expenses;

        return
           [
               Stat::make('Income',$income . ' OMR')
               ->icon('heroicon-o-currency-dollar')
               ->color('#f00'),
               Stat::make('Expenses', $expenses . ' OMR')
                   ->icon('heroicon-o-currency-dollar')
                   ->color('danger'),
               Stat::make('Net Income', $net_income . ' OMR')
                   ->color('warning')
                   ->icon('heroicon-o-currency-dollar')
           ];
    }
}
