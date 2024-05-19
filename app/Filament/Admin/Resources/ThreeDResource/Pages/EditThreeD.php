<?php

namespace App\Filament\Admin\Resources\ThreeDResource\Pages;

use App\Filament\Admin\Resources\ThreeDResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditThreeD extends EditRecord
{
    protected static string $resource = ThreeDResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
