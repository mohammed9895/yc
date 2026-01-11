<?php

namespace App\Filament\Admin\Resources\Halls\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Halls\HallResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHalls extends ListRecords
{

    use Translatable;

    protected static string $resource = HallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
