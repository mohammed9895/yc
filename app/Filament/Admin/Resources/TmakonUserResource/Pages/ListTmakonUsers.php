<?php

namespace App\Filament\Admin\Resources\TmakonUserResource\Pages;

use App\Filament\Admin\Resources\TmakonUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTmakonUsers extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = TmakonUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
