<?php

namespace App\Filament\Admin\Resources\Paths\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Paths\PathResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaths extends ListRecords
{
    protected static string $resource = PathResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
