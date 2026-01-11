<?php

namespace App\Filament\Admin\Resources\Bookings\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Bookings\BookingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
