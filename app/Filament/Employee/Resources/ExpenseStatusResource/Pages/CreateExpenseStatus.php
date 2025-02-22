<?php

namespace App\Filament\Employee\Resources\ExpenseStatusResource\Pages;

use App\Filament\Employee\Resources\ExpenseStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExpenseStatus extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = ExpenseStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
