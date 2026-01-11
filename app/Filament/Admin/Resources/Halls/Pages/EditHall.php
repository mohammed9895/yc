<?php

namespace App\Filament\Admin\Resources\Halls\Pages;

use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Halls\HallResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditHall extends EditRecord
{
    use Translatable;

    protected static string $resource = HallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            DeleteAction::make(),
        ];
    }
}
