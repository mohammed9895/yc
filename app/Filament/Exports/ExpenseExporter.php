<?php

namespace App\Filament\Exports;

use App\Models\Expense;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ExpenseExporter extends Exporter
{
    protected static ?string $model = Expense::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('expenses_id')
                ->label('Expenses ID'),
            ExportColumn::make('expenses_date')
                ->label('Expenses Date'),
            ExportColumn::make('cr_civil_id')
                ->label('CR Number / Civil ID'),
            ExportColumn::make('contractor.name')
                ->label('Contractor'),
            ExportColumn::make('amount')
                ->label('Amount'),
            ExportColumn::make('contractorCategory.name')
                ->label('Contractor Category'),
            ExportColumn::make('term.name')
                ->label('Term'),
            ExportColumn::make('department.name')
                ->label('Department'),
            ExportColumn::make('source.name')->label('Source'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('expense_status_id'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your expense export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
