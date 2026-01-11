<?php

namespace App\Filament\Admin\Resources\Talent\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Talent\TalentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTalent extends EditRecord
{
    protected static string $resource = TalentResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
