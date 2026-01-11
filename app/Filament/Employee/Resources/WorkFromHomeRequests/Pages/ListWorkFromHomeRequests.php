<?php

namespace App\Filament\Employee\Resources\WorkFromHomeRequests\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Employee\Resources\WorkFromHomeRequests\WorkFromHomeRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkFromHomeRequests extends ListRecords
{
    protected static string $resource = WorkFromHomeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
