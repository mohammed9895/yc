<?php

namespace App\Filament\Employee\Resources\Sources\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use App\Filament\Employee\Resources\Sources\SourceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSource extends CreateRecord
{
    use Translatable;

    protected static string $resource = SourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
