<?php
namespace App\Jobs;

use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 30;
    public array $backoff = [5, 30, 60];

    public function __construct(
        public readonly string $phone,
        public readonly string $otp
    ) {
        $this->onQueue('critical');
    }

    public function handle(SmsService $sms): void
    {
        $sms->send($this->phone, "Your PCA OTP is: {$this->otp}. Valid for 10 minutes. Do not share with anyone.");
    }
}