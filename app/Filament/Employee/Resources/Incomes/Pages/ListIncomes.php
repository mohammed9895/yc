<?php

namespace App\Filament\Employee\Resources\Incomes\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Employee\Resources\Incomes\IncomeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncomes extends ListRecords
{
    protected static string $resource = IncomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
