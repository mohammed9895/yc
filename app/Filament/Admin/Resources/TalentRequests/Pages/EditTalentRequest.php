<?php

namespace App\Filament\Admin\Resources\TalentRequests\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\TalentRequests\TalentRequestResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTalentRequest extends EditRecord
{
    protected static string $resource = TalentRequestResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
