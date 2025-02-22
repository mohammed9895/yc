<?php

namespace App\Filament\Employee\Resources\ExpenseStatusResource\Pages;

use App\Filament\Employee\Resources\ExpenseStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExpenseStatuses extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = ExpenseStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
