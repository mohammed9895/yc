<?php

namespace App\Filament\Admin\Resources\PhotographyCompetitions\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\PhotographyCompetitions\PhotographyCompetitionsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPhotographyCompetitions extends ListRecords
{
    protected static string $resource = PhotographyCompetitionsResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
