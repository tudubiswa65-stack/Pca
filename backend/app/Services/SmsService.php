<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{
    public function send(string $to, string $message): void
    {
        // Format phone: prepend +91 if not already international format
        if (!str_starts_with($to, '+')) {
            $to = '+91' . ltrim($to, '0');
        }

        try {
            $sid = config('services.twilio.sid');
            $token = config('services.twilio.token');
            $from = config('services.twilio.from');

            if (!$sid || !$token || !$from) {
                Log::info("SMS (no credentials): To={$to}, Message={$message}");
                return;
            }

            $client = new \Twilio\Rest\Client($sid, $token);
            $client->messages->create($to, ['from' => $from, 'body' => $message]);
            Log::info("SMS sent to {$to}");
        } catch (\Exception $e) {
            Log::error("SMS failed to {$to}: " . $e->getMessage());
        }
    }
}