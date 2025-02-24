<?php
namespace App\Jobs;

use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendContactMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $name, $email, $subject, $usermessage;

    public function __construct($data)
    {
        $this->email = $data['email'];
        $this->subject = $data['subject'];
        $this->usermessage = $data['message'];
        $this->name = $data['name'];
    }

    public function handle(): void
    {
        try {
            Mail::to($this->email)->send(new SendMail($this->name, $this->usermessage));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
        }
    }
}
