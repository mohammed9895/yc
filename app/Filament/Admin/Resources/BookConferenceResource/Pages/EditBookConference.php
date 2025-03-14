<?php

namespace App\Filament\Admin\Resources\BookConferenceResource\Pages;

use App\Filament\Admin\Resources\BookConferenceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookConference extends EditRecord
{
    protected static string $resource = BookConferenceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
