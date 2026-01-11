<?php

namespace App\Filament\Admin\Resources\TmakonUsers\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\TmakonUsers\TmakonUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTmakonUsers extends ListRecords
{
    use Translatable;

    protected static string $resource = TmakonUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
