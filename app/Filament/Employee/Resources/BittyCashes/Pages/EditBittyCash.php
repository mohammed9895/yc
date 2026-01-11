<?php

namespace App\Filament\Employee\Resources\BittyCashes\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Employee\Resources\BittyCashes\BittyCashResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBittyCash extends EditRecord
{
    protected static string $resource = BittyCashResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
