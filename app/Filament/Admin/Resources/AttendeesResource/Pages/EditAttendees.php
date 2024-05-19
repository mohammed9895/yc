<?php

namespace App\Filament\Admin\Resources\AttendeesResource\Pages;

use App\Filament\Admin\Resources\AttendeesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttendees extends EditRecord
{
    protected static string $resource = AttendeesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
