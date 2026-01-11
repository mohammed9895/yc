<?php

namespace App\Filament\Admin\Resources\Cybersecurities\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Cybersecurities\CybersecurityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCybersecurities extends ListRecords
{
    protected static string $resource = CybersecurityResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
