<?php

namespace App\Filament\Employee\Resources\BittyCashes\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Employee\Resources\BittyCashes\BittyCashResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBittyCashes extends ListRecords
{
    protected static string $resource = BittyCashResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
