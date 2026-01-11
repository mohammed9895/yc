<?php

namespace App\Filament\Admin\Resources\Tinders\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Tinders\TinderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTinders extends ListRecords
{
    protected static string $resource = TinderResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
