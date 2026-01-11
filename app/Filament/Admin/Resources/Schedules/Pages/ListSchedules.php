<?php

namespace App\Filament\Admin\Resources\Schedules\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Schedules\ScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSchedules extends ListRecords
{
    protected static string $resource = ScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
