<?php

namespace App\Filament\Admin\Resources\EventResource\Pages;

use App\Filament\Admin\Resources\EventResource;
use App\Models\Event;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function beforeCreate(): void
    {
        $events = Event::where('hall_id', $this->data['hall_id'])
            ->where('start', '<', $this->data['end'])
            ->where('end', '>', $this->data['start'])
            ->count();
        if ($events > 0) {
            Notification::make()
                ->title('This event timing is not available!')
                ->warning()
                ->send();
            $this->halt();
        }
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create([
            'title' => $data['title'],
            'user_id' => Auth::id(),
            'hall_id' => $data['hall_id'],
            'reasone' => $data['reasone'],
            'pax' => $data['pax'],
            'start' => $data['start'],
            'end' => $data['end'],
        ]);
    }
}
