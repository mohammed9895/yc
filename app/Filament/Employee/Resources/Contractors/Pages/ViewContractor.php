<?php

namespace App\Filament\Employee\Resources\Contractors\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Employee\Resources\Contractors\ContractorResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContractor extends ViewRecord
{

    protected static string $resource = ContractorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
