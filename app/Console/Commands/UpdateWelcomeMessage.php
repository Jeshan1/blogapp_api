<?php

namespace App\Console\Commands;

use App\Models\Message;
use Illuminate\Console\Command;

class UpdateWelcomeMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-welcome-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the welcome message every 10 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $message = Message::latest()->first();

        if (!$message) {
            Message::create([
                'message'=>'Welcome In Our Blog App'
            ]);
        }else{
            $message->update([
                'message'=>'Welcome! This message appears every 10 minutes at '. now()->toDateTimeLocalString()
            ]);
        }

        $this->info('Message Updated Successfully');
    }
}
