<?php

namespace App\Filament\Admin\Resources\PlaceResource\Pages;

use App\Filament\Admin\Resources\PlaceResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePlace extends CreateRecord
{
    protected static string $resource = PlaceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $input_json = ['en' => $data['name_en'], 'ar' => $data['name_ar']];

        $data['name'] = $input_json;
        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create([
            'name' => $data['name']
        ]);
    }
}
