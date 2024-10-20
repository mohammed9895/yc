<?php

namespace App\Livewire\User;

use App\Booking\AvailabilityTransformer;
use App\Booking\Date;
use App\Booking\ServiceSlotAvailability;
use App\Booking\Slot;
use App\Livewire\Forms\CheckoutForm;
use App\Models\Event;
use App\Models\Hall;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use LivewireUI\Modal\ModalComponent;

class BookHallModel extends ModalComponent
{
    public Hall $hall;
    public CheckoutForm $form;

    public function mount()
    {
        $this->form->date = $this->availability->firstAvailableDate()?->date->toDateString() ?? now()->toDateString();
    }

    public function submit()
    {
        $this->form->validate();

        unset($this->availability);

        if (!$this->availability->forDate($this->form->date)?->containsSlot($this->form->time)) {
            $this->addError('form.time', 'That slot was taken while you were making your booking. Try another one.');
            return;
        }

        $event = $this->createEvent();

        return redirect()->route('events.show', $event);
    }

    protected function createEvent()
    {

        $event = Event::create([
            'title' => $this->form->title,
            'user_id' => auth()->id(),
            'hall_id' => $this->hall->id,
            'reasone' => $this->form->reasone,
            'pax' => $this->form->pax,
                'start' => Carbon::parse($this->form->date)->setTimeFromTimeString($this->form->slots[0]),
                'end' => Carbon::parse($this->form->date)->setTimeFromTimeString(end($this->form->slots)), // assuming a fixed duration for events, adjust as necessary
            ]
        );

        return $event;
    }

    public function setDate(?string $date)
    {
        if (is_null($date)) {
            return;
        }

        $this->form->date = $date;
    }

    public function setTime(string $time)
    {
        $this->form->time = $time;
        if (empty($this->form->slots)) {
            $this->form->slots[] = $time;
            return;
        }else{
            $lastTime = end($this->form->slots);
            $lastTimeCarbon = Carbon::createFromFormat('H:i', $lastTime);
            $newTimeCarbon = Carbon::createFromFormat('H:i', $time);
            // Calculate the difference in hours
            $differenceInHours = $lastTimeCarbon->diffInMinutes($newTimeCarbon);
            // Add the new time if the difference is exactly 1 hour
            if ($differenceInHours === 30.0) {
                if (count($this->form->slots) < 4) {
                    $this->form->slots[] = $time;
                }
            }else{
                $this->form->slots = [];
                $this->form->slots[] = $time;
            }
        }

        // No need for next available hall since we assume the hall is already chosen
    }

    #[Computed()]
    public function times()
    {
        return $this->slots?->map(function (Slot $slot) {
            return $slot->time->toTimeString('minutes');
        })
            ->values();
    }

    #[Computed()]
    public function slots()
    {
        return $this->availability->first(function (Date $date) {
            return $date->date->toDateString() === $this->form->date;
        })?->slots;
    }

    #[Computed()]
    public function availabilityJson()
    {
        $AvailabilityTransformered  =  new AvailabilityTransformer($this->availability);
        return $AvailabilityTransformered;
    }

    #[Computed(persist: true)]
    public function availability()
    {
        $serviceSlot = (new ServiceSlotAvailability(
            collect([$this->hall]), null
        ))
            ->forPeriod(
                now()->startOfDay(),
                now()->addMonth(1)->endOfDay()
            );
        return $serviceSlot;
    }

    public function render()
    {
        return view('livewire.user.book-hall-model');
    }
}
