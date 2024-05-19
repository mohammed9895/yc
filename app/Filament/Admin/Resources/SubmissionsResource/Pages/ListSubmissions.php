<?php

namespace App\Filament\Admin\Resources\SubmissionsResource\Pages;

use App\Filament\Admin\Resources\SubmissionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubmissions extends ListRecords
{
    protected static string $resource = SubmissionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
