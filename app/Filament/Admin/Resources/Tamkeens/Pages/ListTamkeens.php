<?php

namespace App\Filament\Admin\Resources\Tamkeens\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Tamkeens\TamkeenResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTamkeens extends ListRecords
{
    protected static string $resource = TamkeenResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
