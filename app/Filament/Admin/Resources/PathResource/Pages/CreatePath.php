<?php

namespace App\Filament\Admin\Resources\PathResource\Pages;

use App\Filament\Admin\Resources\PathResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePath extends CreateRecord
{
    protected static string $resource = PathResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $name_json = ['en' => $data['name_en'], 'ar' => $data['name_ar']];
        $data['name'] = $name_json;

        $description_json = ['en' => $data['description_en'], 'ar' => $data['description_ar']];
        $data['description'] = $description_json;

        $icon_json = ['en' => $data['icon_en'], 'ar' => $data['icon_ar']];
        $data['icon'] = $icon_json;

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'icon' => $data['icon'],
            'status' => $data['status']
        ]);
    }
}
