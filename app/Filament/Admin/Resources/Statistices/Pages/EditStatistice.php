<?php

namespace App\Filament\Admin\Resources\Statistices\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Statistices\StatisticeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditStatistice extends EditRecord
{
    use Translatable;

    protected static string $resource = StatisticeResource::class;


    protected function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
            DeleteAction::make(),
        ];
    }
}
