<?php

namespace App\Booking;

use App\Models\Hall;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Slot
{
    public Collection $halls;

    public function __construct(public Carbon $time)
    {
        $this->halls = collect();
    }

    public function addHall(Hall $hall)
    {
        $this->halls->push($hall);
    }

    public function hasHalls()
    {
        return $this->halls->isNotEmpty();
    }
}
