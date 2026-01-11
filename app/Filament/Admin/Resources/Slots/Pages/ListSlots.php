<?php

namespace App\Filament\Admin\Resources\Slots\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Slots\SlotResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSlots extends ListRecords
{
    protected static string $resource = SlotResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
