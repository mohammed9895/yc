<?php

namespace App\Filament\Employee\Resources\WorkFromHomeRequests\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Employee\Resources\WorkFromHomeRequests\WorkFromHomeRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkFromHomeRequest extends EditRecord
{
    protected static string $resource = WorkFromHomeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
