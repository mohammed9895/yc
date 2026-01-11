<?php

namespace App\Filament\Employee\Resources\Terms\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Actions\CreateAction;
use App\Filament\Employee\Resources\Terms\TermResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTerms extends ListRecords
{
    use Translatable;

    protected static string $resource = TermResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
