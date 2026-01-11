<?php

namespace App\Filament\Employee\Resources\ContractorFields\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Actions\CreateAction;
use App\Filament\Employee\Resources\ContractorFields\ContractorFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContractorFields extends ListRecords
{
    use Translatable;

    protected static string $resource = ContractorFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
