<?php

namespace App\Filament\Admin\Resources\FormResource\Pages;

use App\Filament\Admin\Resources\FormResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditForm extends EditRecord
{
    protected static string $resource = FormResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
