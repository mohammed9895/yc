<?php

namespace App\Filament\Admin\Resources\TalentTypes\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\TalentTypes\TalentTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTalentType extends EditRecord
{
    protected static string $resource = TalentTypeResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $names = $data['name'];
        $data['name_en'] = $names['en'];
        $data['name_ar'] = $names['ar'];
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $input_json = ['en' => $data['name_en'], 'ar' => $data['name_ar']];

        $data['name'] = $input_json;
        $record->update([
            'name' => $data['name'],
            'icon' => $data['icon'],
        ]);

        return $record;
    }
}
