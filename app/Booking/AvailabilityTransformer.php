<?php

namespace App\Booking;

use App\Models\Hall;

class AvailabilityTransformer
{
    public function __construct(protected DateCollection $availability)
    {
    }

    public function __toString(): string
    {
        return $this->availability->map(function (Date $date) {
            return [
                'date' => $date->date->toDateString(),
                'slots' => $date->slots->map(function (Slot $slot) {
                    return [
                        'time' => $slot->time->toTimeString('minute'),
                        'halls' => $slot->halls->map(function (Hall $hall) {
                            return $hall->slug;
                        })->values()
                    ];
                })
                    ->values()
            ];
        })
            ->values();
    }
}
