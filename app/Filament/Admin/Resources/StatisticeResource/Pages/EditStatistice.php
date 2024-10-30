<?php

namespace App\Filament\Admin\Resources\StatisticeResource\Pages;

use App\Filament\Admin\Resources\StatisticeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditStatistice extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = StatisticeResource::class;


    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
