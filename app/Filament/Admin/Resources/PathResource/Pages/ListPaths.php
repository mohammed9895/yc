<?php

namespace App\Filament\Admin\Resources\PathResource\Pages;

use App\Filament\Admin\Resources\PathResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaths extends ListRecords
{
    protected static string $resource = PathResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
