<?php

namespace App\Jobs;

use App\Mail\SendBlogNotificationMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendBlogNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $blog;
    public function __construct($blog)
    {
        $this->blog = $blog;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $useremails = User::whereNotIN('role',['admin'])->pluck('email');
            foreach ($useremails as $email) {
                Mail::to($email)->send(new SendBlogNotificationMail($this->blog));
            }
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
        }
    }
}
