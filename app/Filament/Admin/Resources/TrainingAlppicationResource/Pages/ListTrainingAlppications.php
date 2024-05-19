<?php

namespace App\Filament\Admin\Resources\TrainingAlppicationResource\Pages;

use App\Filament\Admin\Resources\TrainingAlppicationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrainingAlppications extends ListRecords
{
    protected static string $resource = TrainingAlppicationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
