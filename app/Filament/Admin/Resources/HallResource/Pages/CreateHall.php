<?php

namespace App\Filament\Admin\Resources\HallResource\Pages;

use App\Filament\Admin\Resources\HallResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateHall extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = HallResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
