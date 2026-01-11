<?php

namespace App\Filament\Admin\Resources\TmakonCtegoryResource\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use App\Filament\Admin\Resources\TmakonCategories\TmakonCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTmakonCtegory extends CreateRecord
{
    use Translatable;

    protected static string $resource = TmakonCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }

}
