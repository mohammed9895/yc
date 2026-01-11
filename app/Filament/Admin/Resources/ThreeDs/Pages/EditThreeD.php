<?php

namespace App\Filament\Admin\Resources\ThreeDs\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\ThreeDs\ThreeDResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditThreeD extends EditRecord
{
    protected static string $resource = ThreeDResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
