<?php

namespace App\Filament\Admin\Resources\PhotographyCompetitions\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\PhotographyCompetitions\PhotographyCompetitionsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPhotographyCompetitions extends EditRecord
{
    protected static string $resource = PhotographyCompetitionsResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
