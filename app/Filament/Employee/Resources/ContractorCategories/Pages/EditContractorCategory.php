<?php

namespace App\Filament\Employee\Resources\ContractorCategories\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Actions\DeleteAction;
use App\Filament\Employee\Resources\ContractorCategories\ContractorCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContractorCategory extends EditRecord
{
    use Translatable;

    protected static string $resource = ContractorCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            DeleteAction::make(),
        ];
    }
}
