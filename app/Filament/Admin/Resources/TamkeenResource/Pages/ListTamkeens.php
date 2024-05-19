<?php

namespace App\Filament\Admin\Resources\TamkeenResource\Pages;

use App\Filament\Admin\Resources\TamkeenResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTamkeens extends ListRecords
{
    protected static string $resource = TamkeenResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
