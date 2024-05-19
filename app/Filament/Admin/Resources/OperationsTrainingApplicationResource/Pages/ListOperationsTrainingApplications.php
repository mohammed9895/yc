<?php

namespace App\Filament\Admin\Resources\OperationsTrainingApplicationResource\Pages;

use App\Filament\Admin\Resources\OperationsTrainingApplicationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOperationsTrainingApplications extends ListRecords
{
    protected static string $resource = OperationsTrainingApplicationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
