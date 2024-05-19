<?php

namespace App\Filament\Admin\Resources\SlotResource\Pages;

use App\Filament\Admin\Resources\SlotResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSlot extends EditRecord
{
    protected static string $resource = SlotResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
