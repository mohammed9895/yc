<?php

namespace App\Filament\Admin\Resources\TrainingAlppications\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\TrainingAlppications\TrainingAlppicationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrainingAlppication extends EditRecord
{
    protected static string $resource = TrainingAlppicationResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
