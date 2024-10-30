<?php

namespace App\Filament\Admin\Resources\TmakonUserResource\Pages;

use App\Filament\Admin\Resources\TmakonUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTmakonUser extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = TmakonUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
