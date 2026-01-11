<?php

namespace App\Filament\Employee\Resources\Expenses\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Employee\Resources\Expenses\ExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExpenses extends ListRecords
{
    protected static string $resource = ExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
