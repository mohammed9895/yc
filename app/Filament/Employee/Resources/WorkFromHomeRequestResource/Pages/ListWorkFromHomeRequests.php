<?php

namespace App\Filament\Employee\Resources\WorkFromHomeRequestResource\Pages;

use App\Filament\Employee\Resources\WorkFromHomeRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkFromHomeRequests extends ListRecords
{
    protected static string $resource = WorkFromHomeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
