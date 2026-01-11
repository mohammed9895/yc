<?php

namespace App\Filament\Employee\Resources\ContractorCategories\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Actions\CreateAction;
use App\Filament\Employee\Resources\ContractorCategories\ContractorCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContractorCategories extends ListRecords
{
    use Translatable;

    protected static string $resource = ContractorCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
