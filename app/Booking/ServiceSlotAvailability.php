<?php

namespace App\Booking;

use App\Models\Event;
use App\Models\Hall;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\Period\Boundaries;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;
use Spatie\Period\Precision;

class ServiceSlotAvailability
{
    public function __construct(protected Collection $halls) {}

    public function forPeriod(Carbon $startsAt, Carbon $endsAt)
    {
        $range = (new SlotGenerator($startsAt, $endsAt))->generate(30); // Assuming 60 minutes interval

        $this->halls->each(function (Hall $hall) use ($startsAt, $endsAt, &$range) {
            $periods = (new ScheduleAvailability($hall))->forPeriod($startsAt, $endsAt);
            ray('1', $periods);
            $periods = $this->removeEvents($periods, $hall);
            ray('2', $periods);
            foreach ($periods as $period) {
                $this->addAvailableHallForPeriod($range, $period, $hall);
            }
        });

        $range = $this->removeEmptySlots($range);

        ray('ranges', $range);
        return $range;
    }

    protected function removeEvents(PeriodCollection $periods, Hall $hall)
    {
        $hall->events->each(function (Event $event) use (&$periods) {
            $periods = $periods->subtract(
                Period::make(
                    $event->start,
                    $event->end,
                    Precision::MINUTE(),
                    Boundaries::EXCLUDE_ALL()
                )
            );
        });

        return $periods;
    }

    protected function removeEmptySlots(DateCollection $range)
    {
        return $range->filter(function (Date $date) {
            $date->slots = $date->slots->filter(function (Slot $slot) {
                return $slot->hasHalls();
            });

            return $date->slots->isNotEmpty();
        });
    }

    protected function addAvailableHallForPeriod(DateCollection $range, Period $period, Hall $hall)
    {
        $range->each(function (Date $date) use ($period, $hall) {
            $date->slots->each(function (Slot $slot) use ($period, $hall) {
                if ($period->contains($slot->time)) {
                    $slot->addHall($hall);
                }
            });
        });
    }
}
