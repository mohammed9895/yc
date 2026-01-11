<?php

namespace App\Filament\Admin\Resources\TrainingAlppications\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\TrainingAlppications\TrainingAlppicationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrainingAlppications extends ListRecords
{
    protected static string $resource = TrainingAlppicationResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
