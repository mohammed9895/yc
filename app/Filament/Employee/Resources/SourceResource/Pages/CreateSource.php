<?php

namespace App\Filament\Employee\Resources\SourceResource\Pages;

use App\Filament\Employee\Resources\SourceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSource extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = SourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
