<?php

namespace App\Filament\Admin\Resources\TmakonCtegoryResource\Pages;

use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\TmakonCategories\TmakonCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTmakonCtegories extends ListRecords
{
    use Translatable;
    protected static string $resource = TmakonCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
