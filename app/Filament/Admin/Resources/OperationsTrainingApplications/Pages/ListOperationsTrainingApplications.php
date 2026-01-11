<?php

namespace App\Filament\Admin\Resources\OperationsTrainingApplications\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\OperationsTrainingApplications\OperationsTrainingApplicationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOperationsTrainingApplications extends ListRecords
{
    protected static string $resource = OperationsTrainingApplicationResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
