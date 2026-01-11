<?php

namespace App\Filament\Employee\Resources\ExpenseStatuses\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use App\Filament\Employee\Resources\ExpenseStatuses\ExpenseStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExpenseStatus extends CreateRecord
{
    use Translatable;

    protected static string $resource = ExpenseStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
