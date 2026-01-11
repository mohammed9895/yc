<?php

namespace App\Filament\Admin\Resources\TmakonUsers\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use App\Filament\Admin\Resources\TmakonUsers\TmakonUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTmakonUser extends CreateRecord
{
    use Translatable;

    protected static string $resource = TmakonUserResource::class;


    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
