<?php

namespace App\Filament\Admin\Resources\EvaluateResource\Pages;

use App\Filament\Admin\Resources\EvaluateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvaluate extends EditRecord
{
    protected static string $resource = EvaluateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
