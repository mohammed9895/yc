<?php

namespace App\Filament\Admin\Resources\TmakonUsers\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\TmakonUsers\TmakonUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTmakonUser extends EditRecord
{
    use Translatable;

    protected static string $resource = TmakonUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            DeleteAction::make(),
        ];
    }
}
