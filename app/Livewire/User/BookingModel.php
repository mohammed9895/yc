<?php

namespace App\Livewire\User;

use App\Notifications\SmsMessage;
use Carbon\Carbon;
use App\Models\Slot;
use App\Models\Booking;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use LivewireUI\Modal\ModalComponent;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Config;
use Filament\Notifications\Notification;

class BookingModel extends ModalComponent
{
    use WithFileUploads;

    public $workshop;
    public $slots;
    public $slot_id;
    public $user;
    public $reasone;
    public $accept = false;

    public $answers = [];

    public $questions;

    public function mount(Workshop $workshop)
    {
        $this->workshop = $workshop;
        $this->slots = Slot::where('start_date', '>=', date('Y-m-d'))->where('workshop_id', '=', $this->workshop->id)->with('bookings')->get();
        $this->questions = Workshop::all()->where('id', $this->workshop->id);
    }
    public function render()
    {
        return view('livewire.user.booking-model');
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }



    public function book(Request $request)
    {
        $this->validate([
            'answers.open_question' => ['sometimes','required', 'max:255'],
            'answers.upload_question' => ['sometimes', 'required'],
            'answers.options_question' => ['sometimes', 'required'],
        ]);
        if ($this->accept) {

            $bookings_count = Booking::where('workshop_id', '=', $this->workshop->id)->where('status', 2)->where('slot_id', '=', $this->slot_id)->count();

            if ($bookings_count < $this->workshop->capacity) {
                $if_user_booked = Booking::where('workshop_id', '=', $this->workshop->id)->where('slot_id', $this->slot_id)->where('status', 2)->where('user_id', '=', Auth::id())->count();
                if ($if_user_booked == 0) {
                    $slot = Slot::where('id', '=', $this->slot_id)->first();
                    $have_booked_same_slot = Booking::where('workshop_id', '=', $this->workshop->id)->where('slot_id', $this->slot_id)->where('status', 0)->where('user_id', '=', Auth::id())->count();
                    if ($this->slot_id == null) {
                        $this->closeModal();

                        return Notification::make()
                            ->title('You have not choose a slot  or it fully booked!')
                            ->danger()
                            ->send();

                    } elseif ($have_booked_same_slot > 0) {
                        $this->closeModal();
                        Notification::make()
                            ->title('You are already booked you seat!')
                            ->danger()
                            ->send();
                    } else {
                        $answers_finals = [];
                        foreach ($this->answers as $questionType => $questionData){
                           if ($questionType == 'upload_question'){
                               foreach ($questionData as $question => $answer) {
                                   $extension = $answer->getClientOriginalExtension();
                                   $uniqueId = Str::random(10);
                                   $timestamp = now()->format('YmdHis');
                                   $finalFileName = $timestamp . '_' . $uniqueId . '.' . $extension;
                                   $answer->storeAs('answers/'.Str::kebab($this->workshop->getTranslation('title', 'en')), $finalFileName);
                                   $answers_finals[] = [$question => "answers/" . Str::kebab($this->workshop->getTranslation('title', 'en')) . "/" .$finalFileName];
                               }
                           }
                           else {
                               $answers_finals[] = $questionData;
                           }
                        }
                        Booking::create([
                            'workshop_id' => $this->workshop->id,
                            'slot_id' => $this->slot_id,
                            'user_id' => Auth::id(),
                            'answers' => $answers_finals,
                            'reasone' => $this->reasone
                        ]);

                        Notification::make()
                            ->title('You have booked your seat!')
                            ->success()
                            ->send();

                        $user = auth()->user();

                        $sms = new SmsMessage;
                        if ($user->preferred_language == 'ar') {
                            $sms->to($user->phone)
                                ->message("تم استلام طلبك للالتحاق ببرنامج " . $this->workshop->getTranslation('title', 'ar') . 'سنقوم بالتواصل معك بعد عملية الفرز ')
                                ->lang($user->preferred_language)
                                ->send();
                        } else {
                            $sms->to($user->phone)
                                ->message("Your enrolment request have been recived for " . $this->workshop->getTranslation('title', 'en') . 'we will contact you after the screening process')
                                ->lang($user->preferred_language)
                                ->send();
                        }

                        $this->closeModal();
                    }

                } else {
                    $this->closeModal();
                    Notification::make()
                        ->title('You are already booked you seat!')
                        ->danger()
                        ->send();
                }
            } else {
                $this->closeModal();
                Notification::make()
                    ->title('Workshop is fully booked!')
                    ->danger()
                    ->send();
            }
        }
        else {
            Notification::make()
                ->title('Please accept the terms and conditions!')
                ->danger()
                ->send();
        }
    }
}
