<?php

namespace App\Filament\Employee\Resources\ContractorCategoryResource\Pages;

use App\Filament\Employee\Resources\ContractorCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;
use Filament\Resources\Pages\ListRecords;

class ListContractorCategories extends ListRecords
{
    use Translatable;

    protected static string $resource = ContractorCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
