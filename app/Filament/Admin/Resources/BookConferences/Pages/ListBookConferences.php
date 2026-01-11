<?php

namespace App\Filament\Admin\Resources\BookConferences\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\BookConferences\BookConferenceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookConferences extends ListRecords
{
    protected static string $resource = BookConferenceResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
