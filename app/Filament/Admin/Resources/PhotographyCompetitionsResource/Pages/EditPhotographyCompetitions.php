<?php

namespace App\Filament\Admin\Resources\PhotographyCompetitionsResource\Pages;

use App\Filament\Admin\Resources\PhotographyCompetitionsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPhotographyCompetitions extends EditRecord
{
    protected static string $resource = PhotographyCompetitionsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
