<?php

namespace App\Filament\Admin\Resources\Workshops\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Workshops\WorkshopResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkshops extends ListRecords
{
    protected static string $resource = WorkshopResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
