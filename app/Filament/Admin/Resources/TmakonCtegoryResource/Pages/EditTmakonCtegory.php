<?php

namespace App\Filament\Admin\Resources\TmakonCtegoryResource\Pages;

use App\Filament\Admin\Resources\TmakonCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTmakonCtegory extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    protected static string $resource = TmakonCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
