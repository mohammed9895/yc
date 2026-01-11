<?php

namespace App\Filament\Admin\Resources\LinkedinDitales\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\LinkedinDitales\LinkedinDitalesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLinkedinDitales extends ListRecords
{
    protected static string $resource = LinkedinDitalesResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
