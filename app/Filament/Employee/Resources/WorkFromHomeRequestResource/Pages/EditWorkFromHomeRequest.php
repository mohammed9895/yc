<?php

namespace App\Filament\Employee\Resources\WorkFromHomeRequestResource\Pages;

use App\Filament\Employee\Resources\WorkFromHomeRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkFromHomeRequest extends EditRecord
{
    protected static string $resource = WorkFromHomeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
