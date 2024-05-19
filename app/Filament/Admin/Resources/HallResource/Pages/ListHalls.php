<?php

namespace App\Filament\Admin\Resources\HallResource\Pages;

use App\Filament\Admin\Resources\HallResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHalls extends ListRecords
{
    protected static string $resource = HallResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
