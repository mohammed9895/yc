<?php

namespace App\Filament\Admin\Resources\Places\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Places\PlaceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlaces extends ListRecords
{
    protected static string $resource = PlaceResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
