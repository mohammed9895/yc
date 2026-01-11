<?php

namespace App\Filament\Employee\Resources\ContractorFields\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Actions\DeleteAction;
use App\Filament\Employee\Resources\ContractorFields\ContractorFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContractorField extends EditRecord
{
    use Translatable;

    protected static string $resource = ContractorFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            DeleteAction::make(),
        ];
    }
}
