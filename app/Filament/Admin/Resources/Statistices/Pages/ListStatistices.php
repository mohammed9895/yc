<?php

namespace App\Filament\Admin\Resources\Statistices\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Statistices\StatisticeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatistices extends ListRecords
{
    use Translatable;

    protected static string $resource = StatisticeResource::class;

    protected function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
