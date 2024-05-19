<?php

namespace App\Filament\Admin\Resources\TrainingAlppicationResource\Pages;

use App\Filament\Admin\Resources\TrainingAlppicationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrainingAlppication extends EditRecord
{
    protected static string $resource = TrainingAlppicationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
