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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SendMuscatSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $key = 'muscat_sms_progress';

        Cache::put($key, [
            'status' => 'running',
            'sent' => 0,
            'failed' => 0,
            'current_phone' => null,
            'last_message' => null,
            'started_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
            'items' => [],
        ], now()->addHours(6));

        // build message + $lang here (same as before)

        $users = User::where('province_id', '1')
            ->whereNotNull('phone')
            ->get();

        // Message based on locale
        if (Config::get('app.locale') === 'ar') {
            $message = "أجواء الشتاء بتكون غير مع لمّتنا الشبابية 🌙❄️ https://yc.om/cp/";
            $lang = '64';
        } else {
            $message = "Winter vibes hit different with our youth gathering ❄️🌙 https://yc.om/cp";
            $lang = '0';
        }

        foreach ($users as $user) {
            $phone = $user->phone;

            try {
                $res = Http::post(
                    'https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx'
                    . '?UserId=' . env('User_ID_OTP', 'youthsmsweb')
                    . '&Password=' . env('OTP_Password', 'L!ulid80')
                    . '&MobileNo=' . $phone
                    . '&Message=' . $message
                    . '&PushDateTime=10/12/2022 02:03'
                    . '&Lang=' . $lang
                    . '&FLashSMS=N'
                );

                Log::info('Muscat SMS sent', [
                    'phone' => $phone,
                    'response' => $res->body(),
                ]);

                $p = Cache::get($key);
                $p['sent']++;
                $p['current_phone'] = $phone;
                $p['updated_at'] = now()->toDateTimeString();
                $p['items'][] = ['phone' => $phone, 'status' => 'sent', 'at' => now()->toDateTimeString()];
                $p['items'] = array_slice($p['items'], -200); // keep last 200 only
                Cache::put($key, $p, now()->addHours(6));

            } catch (\Throwable $e) {
                Log::error('Muscat SMS failed', [
                    'phone' => $phone,
                    'error' => $e->getMessage(),
                ]);

                $p = Cache::get($key);
                $p['failed']++;
                $p['current_phone'] = $phone;
                $p['updated_at'] = now()->toDateTimeString();
                $p['items'][] = ['phone' => $phone, 'status' => 'failed', 'at' => now()->toDateTimeString()];
                $p['items'] = array_slice($p['items'], -200);
                Cache::put($key, $p, now()->addHours(6));
            }
        }

        $p = Cache::get($key);
        $p['status'] = 'finished';
        $p['updated_at'] = now()->toDateTimeString();
        Cache::put($key, $p, now()->addHours(6));
    }

}
