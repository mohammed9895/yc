<?php

namespace App\Filament\Employee\Widgets;

use App\Models\Contractor;
use App\Models\ContractorField;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContractorFieldsExpanses extends BaseWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 5;

    protected ?string $heading = 'Analytics';
    protected function getStats(): array
    {
        $fields = ContractorField::with('contractors.expenses')->get(); // Load contractors and their expenses

        $expensesByField = [];

        foreach ($fields as $field) {
            $totalExpenses = $field->contractors->sum(fn($contractor) => $contractor->expenses->sum('amount'));

            $expensesByField[$field->name] = $totalExpenses;
        }

        $stats = [];

        foreach ($expensesByField as $field => $expense) {
            $stats[] = Stat::make("Expenses for {$field}", $expense . ' OMR')
                ->icon('heroicon-o-currency-dollar')
                ->color('danger');
        }

        return $stats;
    }
}
