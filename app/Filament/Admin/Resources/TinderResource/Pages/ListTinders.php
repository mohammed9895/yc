<?php

namespace App\Filament\Admin\Resources\TinderResource\Pages;

use App\Filament\Admin\Resources\TinderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTinders extends ListRecords
{
    protected static string $resource = TinderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
