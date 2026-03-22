<?php
namespace App\Jobs;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public readonly int $userId)
    {
        $this->onQueue('high');
    }

    public function handle(): void
    {
        $user = User::find($this->userId);
        if (!$user || !$user->email) return;
        Mail::to($user->email)->send(new WelcomeMail($user));
    }
}