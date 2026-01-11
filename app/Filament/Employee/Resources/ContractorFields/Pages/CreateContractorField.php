<?php

namespace App\Filament\Employee\Resources\ContractorFields\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use App\Filament\Employee\Resources\ContractorFields\ContractorFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContractorField extends CreateRecord
{
    use Translatable;

    protected static string $resource = ContractorFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
