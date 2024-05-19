<?php

namespace App\Filament\Admin\Resources\StatisticeResource\Pages;

use App\Filament\Admin\Resources\StatisticeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatistices extends ListRecords
{
    protected static string $resource = StatisticeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
