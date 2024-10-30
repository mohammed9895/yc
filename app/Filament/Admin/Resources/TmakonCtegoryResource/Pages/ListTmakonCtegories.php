<?php

namespace App\Filament\Admin\Resources\TmakonCtegoryResource\Pages;

use App\Filament\Admin\Resources\TmakonCategoryResource;
use Filament\Actions;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Pages\ListRecords;

class ListTmakonCtegories extends ListRecords
{
    use Translatable;
    protected static string $resource = TmakonCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
