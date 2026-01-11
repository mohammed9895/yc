<?php

namespace App\Filament\Admin\Resources\Attendees\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Attendees\AttendeesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttendees extends ListRecords
{
    protected static string $resource = AttendeesResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
