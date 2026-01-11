<?php

namespace App\Filament\Employee\Resources\Contractors\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Employee\Resources\Contractors\ContractorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContractor extends EditRecord
{
    protected static string $resource = ContractorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
