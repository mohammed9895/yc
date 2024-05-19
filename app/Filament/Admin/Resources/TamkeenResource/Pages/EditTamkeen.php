<?php

namespace App\Filament\Admin\Resources\TamkeenResource\Pages;

use App\Filament\Admin\Resources\TamkeenResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTamkeen extends EditRecord
{
    protected static string $resource = TamkeenResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
