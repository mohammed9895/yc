<?php

namespace App\Livewire\User;

use App\Booking\AvailabilityTransformer;
use App\Booking\Date;
use App\Booking\ServiceSlotAvailability;
use App\Booking\Slot;
use App\Livewire\Forms\CheckoutForm;
use App\Models\Event;
use App\Models\Hall;
use App\Notifications\SmsMessage;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
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

       // check if the user has already booked the hall today
        $user = auth()->user();
        $bookingDate = Carbon::parse($this->form->date)->toDateString();

        $userEvents = Event::where('user_id', $user->id)->whereDate('start', $bookingDate)->get();
        if ($userEvents->count() > 0) {
            $this->addError('form.date', 'You have already booked a hall in this date.');
            return;
        }

        $event = $this->createEvent();

        $this->closeModal();

        Notification::make()
            ->title(__('You have booked the hall successfully!'))
            ->success()
            ->persistent()
            ->send();

        $sms = new SmsMessage;
        $user = auth()->user();
        if ($user->preferred_language == 'ar') {
            $sms->to($user->phone)
                ->message('تم استلام طلبك حجزك ل ' . $this->hall->name . ' سوف يتم تأكيد حجزك قريبًا')
                ->lang($user->preferred_language)
                ->send();
        } else {
            $sms->to($user->phone)
                ->message("Your reservation has been received for " . $this->hall->name . ", It will be confirmed soon.")
                ->lang($user->preferred_language)
                ->send();
        }
    }

    protected function createEvent()
    {
        $start = Carbon::parse($this->form->date)->setTimeFromTimeString('18:30');
        $end = Carbon::parse($this->form->date)->setTimeFromTimeString(end($this->form->slots))->addMinutes(30);

        // check if the end time is after the start time
        if ($end->lessThanOrEqualTo($start)) {
            $this->addError('form.time', 'The end time must be after the start time.');
            return;
        }

        return Event::create([
            'title' => $this->form->title,
            'user_id' => auth()->id(),
            'hall_id' => $this->hall->id,
            'reasone' => $this->form->reasone,
            'pax' => $this->form->pax,
            'start' => $start,
            'end' => $end, // assuming a fixed duration for events, adjust as necessary
            ]
        );
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
                if (count($this->form->slots) < 8) {
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
