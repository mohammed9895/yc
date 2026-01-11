<?php

namespace App\Filament\Admin\Resources\TalentTypes\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\TalentTypes\TalentTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTalentTypes extends ListRecords
{
    protected static string $resource = TalentTypeResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
