<?php

namespace App\Filament\Employee\Resources\ExpenseStatusResource\Pages;

use App\Filament\Employee\Resources\ExpenseStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpenseStatus extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = ExpenseStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
