<?php

namespace App\Filament\Employee\Resources\Expenses\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Employee\Resources\Expenses\ExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpense extends EditRecord
{
    protected static string $resource = ExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
