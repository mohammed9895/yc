<?php

namespace App\Filament\Admin\Resources\TalentResource\Pages;

use App\Filament\Admin\Resources\TalentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTalent extends ListRecords
{
    protected static string $resource = TalentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
