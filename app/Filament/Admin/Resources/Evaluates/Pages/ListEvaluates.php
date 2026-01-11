<?php

namespace App\Filament\Admin\Resources\Evaluates\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Evaluates\EvaluateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvaluates extends ListRecords
{
    protected static string $resource = EvaluateResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
