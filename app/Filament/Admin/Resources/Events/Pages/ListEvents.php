<?php

namespace App\Filament\Admin\Resources\Events\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Events\EventResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
