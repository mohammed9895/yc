<?php

namespace App\Filament\Employee\Resources\BittyCashRequests\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Employee\Resources\BittyCashRequests\BittyCashRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBittyCashRequests extends ListRecords
{
    protected static string $resource = BittyCashRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return BittyCashRequestResource::getWidgets();
    }
}
