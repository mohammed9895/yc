<?php

namespace App\Filament\Admin\Resources\SubmissionsResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Submissions\SubmissionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubmissions extends EditRecord
{
    protected static string $resource = SubmissionResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
