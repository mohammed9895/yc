<?php

namespace App\Filament\Admin\Resources\WorkshopResource\Pages;

use App\Filament\Admin\Resources\WorkshopResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkshops extends ListRecords
{
    protected static string $resource = WorkshopResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
