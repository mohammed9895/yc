<?php

namespace App\Filament\Admin\Resources\ThreeDs\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\ThreeDs\ThreeDResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListThreeDS extends ListRecords
{
    protected static string $resource = ThreeDResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
