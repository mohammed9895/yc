<?php

namespace App\Filament\Admin\Resources\OperationsTrainingApplications\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\OperationsTrainingApplications\OperationsTrainingApplicationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOperationsTrainingApplication extends EditRecord
{
    protected static string $resource = OperationsTrainingApplicationResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
