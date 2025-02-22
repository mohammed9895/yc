<?php

namespace App\Filament\Employee\Resources\BittyCashRequestResource\Pages;

use App\Filament\Employee\Resources\BittyCashRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBittyCashRequests extends ListRecords
{
    protected static string $resource = BittyCashRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return BittyCashRequestResource::getWidgets();
    }
}
