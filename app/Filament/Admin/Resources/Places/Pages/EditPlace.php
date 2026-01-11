<?php

namespace App\Filament\Admin\Resources\Places\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Places\PlaceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPlace extends EditRecord
{
    protected static string $resource = PlaceResource::class;

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
            'name' => $data['name']
        ]);

        return $record;
    }
}
