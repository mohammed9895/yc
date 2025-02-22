<?php

namespace App\Filament\Employee\Resources\BittyCashResource\Pages;

use App\Filament\Employee\Resources\BittyCashResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBittyCashes extends ListRecords
{
    protected static string $resource = BittyCashResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
