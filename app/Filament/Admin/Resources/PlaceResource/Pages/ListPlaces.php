<?php

namespace App\Filament\Admin\Resources\PlaceResource\Pages;

use App\Filament\Admin\Resources\PlaceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlaces extends ListRecords
{
    protected static string $resource = PlaceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
