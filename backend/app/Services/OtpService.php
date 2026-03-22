<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class OtpService
{
    public function generate(string $phone): string
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::put("otp:{$phone}", hash('sha256', $otp), now()->addMinutes(10));
        return $otp;
    }

    public function verify(string $phone, string $otp): bool
    {
        $stored = Cache::get("otp:{$phone}");
        if (!$stored) return false;
        $result = hash_equals($stored, hash('sha256', $otp));
        if ($result) Cache::forget("otp:{$phone}");
        return $result;
    }

    public function forget(string $phone): void
    {
        Cache::forget("otp:{$phone}");
    }
}