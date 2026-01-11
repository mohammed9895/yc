<?php

namespace App\Filament\Admin\Resources\Tinders\Pages;

use App\Filament\Admin\Resources\Tinders\TinderResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTinder extends CreateRecord
{
    protected static string $resource = TinderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $title_json = ['en' => $data['title_en'], 'ar' => $data['title_ar']];
        $data['title'] = $title_json;

        $description_json = ['en' => $data['description_en'], 'ar' => $data['description_ar']];
        $data['description'] = $description_json;

        $documens_json = ['en' => $data['document_en'], 'ar' => $data['document_ar']];
        $data['document'] = $documens_json;

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'value' => $data['value'],
            'document' => $data['document'],
            'tender_date' => $data['tinder_date'],
            'status' => $data['status'],
        ]);
    }
}
