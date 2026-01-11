<?php

namespace App\Filament\Admin\Resources\GCCCamps\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\GCCCamps\GCCCampResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGCCCamp extends EditRecord
{
    protected static string $resource = GCCCampResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
