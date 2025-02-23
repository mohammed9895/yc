<?php

namespace App\Filament\Employee\Widgets;

use App\Models\ContractorCategory;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContractorCategoriesExpanses extends BaseWidget
{
    protected static ?int $sort = 5;


    protected function getStats(): array
    {
        $terms = ContractorCategory::with('expenses')->get();

        $stats = [];

        foreach ($terms as $term) {
            $totalExpenses = $term->expenses->sum('amount'); // Assuming 'amount' is the expense column

            $stats[] = Stat::make("Expenses for {$term->name}", $totalExpenses . ' OMR')
                ->icon('heroicon-o-currency-dollar')
                ->color('danger');
        }

        return $stats;
    }
}
