<?php

namespace App\Filament\Admin\Resources\TmakonUserResource\Pages;

use App\Filament\Admin\Resources\TmakonUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTmakonUser extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = TmakonUserResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
