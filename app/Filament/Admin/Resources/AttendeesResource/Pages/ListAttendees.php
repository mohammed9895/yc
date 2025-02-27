<?php

namespace App\Filament\Admin\Resources\AttendeesResource\Pages;

use App\Filament\Admin\Resources\AttendeesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttendees extends ListRecords
{
    protected static string $resource = AttendeesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
