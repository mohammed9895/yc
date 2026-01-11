<?php

namespace App\Filament\Employee\Resources\BittyCashRequests\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Employee\Resources\BittyCashRequests\BittyCashRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBittyCashRequest extends EditRecord
{
    protected static string $resource = BittyCashRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
