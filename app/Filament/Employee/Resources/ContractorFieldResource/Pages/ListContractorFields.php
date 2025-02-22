<?php

namespace App\Filament\Employee\Resources\ContractorFieldResource\Pages;

use App\Filament\Employee\Resources\ContractorFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContractorFields extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = ContractorFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
