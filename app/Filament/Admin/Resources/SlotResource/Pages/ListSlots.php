<?php

namespace App\Filament\Admin\Resources\SlotResource\Pages;

use App\Filament\Admin\Resources\SlotResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSlots extends ListRecords
{
    protected static string $resource = SlotResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
