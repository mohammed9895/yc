<?php

namespace App\Filament\Admin\Resources\LinkedinDitales\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\LinkedinDitales\LinkedinDitalesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLinkedinDitales extends EditRecord
{
    protected static string $resource = LinkedinDitalesResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
