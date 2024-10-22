<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use const _PHPStan_49641e245\__;

class VerifyPhone extends Component
{

    public User $user;
    #[Validate('required|numeric|digits:5')]
    public $otp;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function verify()
    {
        $verified_code = $this->user->phone_verified_code;
//        dd($this->user->phone_verified_at);
        if ($verified_code == $this->otp && !$this->user->phone_verified_at) {
            $this->user->update([
                'phone_verified_at' => now()
            ]);
            $this->redirect('/cp');
        }
        else {
            session()->flash('error', __('The OTP is wrong'));
        }
    }

    public function resend()
    {
        $phone_verified_code = random_int(10000, 99999);
        $messageSms = '';

        $this->user->update([
            'phone_verified_code' => $phone_verified_code
        ]);

        if (Config::get('app.locale') == 'ar') {
            $messageSms = "رمز التأكيد الخاص بك هو: " . $phone_verified_code;
        } else {
            $messageSms = "Your Verification code is " . $phone_verified_code;
        }

        $lang = Config::get('app.locale') == 'ar' ? '64' : '0';

        $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=' . env('User_ID_OTP',
                'youthsmsweb') . '&Password=' . env('OTP_Password',
                'L!ulid80') . '&MobileNo=' . $this->user->phone . '&Message=' . $messageSms . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $lang . '&FLashSMS=N');

        $this->reset();
    }

    #[Layout('layouts.auth')]
    public function render()
    {
        return view('livewire.auth.verify-phone');
    }
}
