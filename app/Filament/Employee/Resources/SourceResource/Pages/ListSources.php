<?php

namespace App\Filament\Employee\Resources\SourceResource\Pages;

use App\Filament\Employee\Resources\SourceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSources extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = SourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
