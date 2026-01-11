<?php

namespace App\Filament\Employee\Resources\ExpenseStatuses\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Actions\CreateAction;
use App\Filament\Employee\Resources\ExpenseStatuses\ExpenseStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExpenseStatuses extends ListRecords
{
    use Translatable;

    protected static string $resource = ExpenseStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
