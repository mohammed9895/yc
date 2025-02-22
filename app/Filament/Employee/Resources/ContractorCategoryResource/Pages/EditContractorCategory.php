<?php

namespace App\Filament\Employee\Resources\ContractorCategoryResource\Pages;

use App\Filament\Employee\Resources\ContractorCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContractorCategory extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = ContractorCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
