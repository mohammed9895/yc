<?php

namespace App\Filament\Admin\Resources\Cybersecurities\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Cybersecurities\CybersecurityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCybersecurity extends EditRecord
{
    protected static string $resource = CybersecurityResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
