<?php

namespace App\Filament\Employee\Resources\EmploymentTypes\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Actions\DeleteAction;
use App\Filament\Employee\Resources\EmploymentTypes\EmploymentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmploymentType extends EditRecord
{
    use Translatable;

    protected static string $resource = EmploymentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            DeleteAction::make(),
        ];
    }
}
