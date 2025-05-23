<?php

namespace App\Filament\Admin\Resources\HallResource\Pages;

use App\Filament\Admin\Resources\HallResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHalls extends ListRecords
{

    use ListRecords\Concerns\Translatable;

    protected static string $resource = HallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
