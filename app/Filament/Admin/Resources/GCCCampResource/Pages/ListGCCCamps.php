<?php

namespace App\Filament\Admin\Resources\GCCCampResource\Pages;

use App\Filament\Admin\Resources\GCCCampResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGCCCamps extends ListRecords
{
    protected static string $resource = GCCCampResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
