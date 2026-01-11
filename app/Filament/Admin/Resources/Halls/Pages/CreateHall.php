<?php

namespace App\Filament\Admin\Resources\Halls\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use App\Filament\Admin\Resources\Halls\HallResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateHall extends CreateRecord
{
    use Translatable;

    protected static string $resource = HallResource::class;
    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
