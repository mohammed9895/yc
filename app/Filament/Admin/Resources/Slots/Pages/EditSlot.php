<?php

namespace App\Filament\Admin\Resources\Slots\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Slots\SlotResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSlot extends EditRecord
{
    protected static string $resource = SlotResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
