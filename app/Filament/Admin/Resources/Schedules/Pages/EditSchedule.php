<?php

namespace App\Filament\Admin\Resources\Schedules\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Schedules\ScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchedule extends EditRecord
{
    protected static string $resource = ScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
