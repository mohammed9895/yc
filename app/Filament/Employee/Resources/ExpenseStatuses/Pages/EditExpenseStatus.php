<?php

namespace App\Filament\Employee\Resources\ExpenseStatuses\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Actions\DeleteAction;
use App\Filament\Employee\Resources\ExpenseStatuses\ExpenseStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpenseStatus extends EditRecord
{
    use Translatable;

    protected static string $resource = ExpenseStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            DeleteAction::make(),
        ];
    }
}
