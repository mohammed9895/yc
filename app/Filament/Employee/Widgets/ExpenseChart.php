<?php

namespace App\Filament\Employee\Widgets;

use App\Models\Expense;
use App\Models\Income;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ExpenseChart extends ChartWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 3;

    protected static ?string $heading = 'Expanses Chart';

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '300px';

    public ?string $filter = 'this_year';

    protected function getData(): array
    {
        $activeFilter = $this->filter;

            $expanse = Trend::model(Expense::class)
                ->between(
                    start: $activeFilter == 'this_year' ? now()->startOfYear() : now()->subYear()->startOfYear(),
                    end: $activeFilter == 'this_year' ? now()->endOfYear() : now()->subYear()->endOfYear(),
                )
                ->perMonth()
                ->sum('amount');

        $income = Trend::model(Income::class)
            ->between(
                start: $activeFilter == 'this_year' ? now()->startOfYear() : now()->subYear()->startOfYear(),
                end: $activeFilter == 'this_year' ? now()->endOfYear() : now()->subYear()->endOfYear(),
            )
            ->perMonth()
            ->sum('amount');


        return [
            'datasets' => [
                [
                    'label' => 'Expanse',
                    'data' => $expanse->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#cd1c18',
                    'borderColor' => '#cd1c18',
                ],
                [
                    'label' => 'Income',
                    'data' => $income->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#2e6f40',
                    'borderColor' => '#2e6f40',
                ],
            ],
            'labels' => $expanse->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'this_year' => 'This year',
            'last_year' => 'Last year',
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
