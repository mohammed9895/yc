<?php

namespace App\Filament\Admin\Resources\BookConferences\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\BookConferences\BookConferenceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookConference extends EditRecord
{
    protected static string $resource = BookConferenceResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
