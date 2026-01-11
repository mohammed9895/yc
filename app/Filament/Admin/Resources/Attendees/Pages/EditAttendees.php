<?php

namespace App\Filament\Admin\Resources\Attendees\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Attendees\AttendeesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttendees extends EditRecord
{
    protected static string $resource = AttendeesResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
