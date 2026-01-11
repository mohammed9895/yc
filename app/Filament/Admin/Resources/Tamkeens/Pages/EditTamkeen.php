<?php

namespace App\Filament\Admin\Resources\Tamkeens\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Tamkeens\TamkeenResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTamkeen extends EditRecord
{
    protected static string $resource = TamkeenResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
