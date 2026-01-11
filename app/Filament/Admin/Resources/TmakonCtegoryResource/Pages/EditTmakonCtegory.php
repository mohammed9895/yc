<?php

namespace App\Filament\Admin\Resources\TmakonCtegoryResource\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\TmakonCategories\TmakonCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTmakonCtegory extends EditRecord
{
    use Translatable;
    protected static string $resource = TmakonCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            DeleteAction::make(),
        ];
    }
}
