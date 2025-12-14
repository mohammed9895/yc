<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class SendMuscatSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // Message based on locale
        if (Config::get('app.locale') === 'ar') {
            $message = "أجواء الشتاء بتكون غير مع لمّتنا الشبابية 🌙❄️ https://yc.om/cp";
            $lang = '64';
        } else {
            $message = "Winter vibes hit different with our youth gathering ❄️🌙 https://yc.om/cp";
            $lang = '0';
        }

        // Get all users in Muscat Governorate
        $users = User::where('province_id', '1')
            ->whereNotNull('phone')
            ->get();

        foreach ($users as $user) {

            try {
                Http::post(
                    'https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx',
                    [
                        'UserId'       => env('User_ID_OTP'),
                        'Password'     => env('OTP_Password'),
                        'MobileNo'     => $user->phone,
                        'Message'      => $message,
                        'PushDateTime' => now()->format('m/d/Y H:i:s'),
                        'Lang'         => $lang,
                        'FLashSMS'     => 'N',
                    ]
                );

            } catch (\Throwable $e) {
                logger()->error('SMS failed', [
                    'phone' => $user->phone,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
