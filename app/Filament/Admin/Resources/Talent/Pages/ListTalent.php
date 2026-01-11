<?php

namespace App\Filament\Admin\Resources\Talent\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Talent\TalentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTalent extends ListRecords
{
    protected static string $resource = TalentResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
