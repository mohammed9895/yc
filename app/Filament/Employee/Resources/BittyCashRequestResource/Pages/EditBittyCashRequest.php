<?php

namespace App\Filament\Employee\Resources\BittyCashRequestResource\Pages;

use App\Filament\Employee\Resources\BittyCashRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBittyCashRequest extends EditRecord
{
    protected static string $resource = BittyCashRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
