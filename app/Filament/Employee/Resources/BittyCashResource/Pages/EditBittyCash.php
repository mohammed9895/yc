<?php

namespace App\Filament\Employee\Resources\BittyCashResource\Pages;

use App\Filament\Employee\Resources\BittyCashResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBittyCash extends EditRecord
{
    protected static string $resource = BittyCashResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
