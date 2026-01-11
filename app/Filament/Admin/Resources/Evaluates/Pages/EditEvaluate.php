<?php

namespace App\Filament\Admin\Resources\Evaluates\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Evaluates\EvaluateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvaluate extends EditRecord
{
    protected static string $resource = EvaluateResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
