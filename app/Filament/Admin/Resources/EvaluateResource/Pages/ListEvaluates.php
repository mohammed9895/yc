<?php

namespace App\Filament\Admin\Resources\EvaluateResource\Pages;

use App\Filament\Admin\Resources\EvaluateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvaluates extends ListRecords
{
    protected static string $resource = EvaluateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
