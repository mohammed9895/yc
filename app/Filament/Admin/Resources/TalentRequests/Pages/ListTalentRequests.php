<?php

namespace App\Filament\Admin\Resources\TalentRequests\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\TalentRequests\TalentRequestResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTalentRequests extends ListRecords
{
    protected static string $resource = TalentRequestResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
