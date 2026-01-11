<?php

namespace App\Filament\Employee\Resources\ContractorCategories\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use App\Filament\Employee\Resources\ContractorCategories\ContractorCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContractorCategory extends CreateRecord
{
    use Translatable;

    protected static string $resource = ContractorCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
