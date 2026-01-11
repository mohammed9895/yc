<?php

namespace App\Filament\Employee\Resources\EmploymentTypes\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use App\Filament\Employee\Resources\EmploymentTypes\EmploymentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmploymentType extends CreateRecord
{
    use Translatable;

    protected static string $resource = EmploymentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
