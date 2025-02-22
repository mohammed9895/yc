<?php

namespace App\Filament\Employee\Widgets;

use App\Models\Term;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TermsExpanses extends BaseWidget
{
    protected static ?int $sort = 2;
    protected function getStats(): array
    {
        $terms = Term::with('expenses')->get();

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
