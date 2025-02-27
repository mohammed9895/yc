<?php

namespace App\Filament\Employee\Resources\TermResource\Pages;

use App\Filament\Employee\Resources\TermResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTerm extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = TermResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
