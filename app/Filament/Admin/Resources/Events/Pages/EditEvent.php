<?php

namespace App\Filament\Admin\Resources\Events\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Events\EventResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
