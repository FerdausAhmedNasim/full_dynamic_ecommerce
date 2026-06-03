<?php

namespace App\Console\Commands;

use App\Models\Email;
use App\Mail\BulkEmail;
use App\Models\EmailRecipient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPostEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:post_email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email to Users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $post_emails = Email::where(['group' => 'post', 'sending_at' => now()->format('y-m-d')])->get();

        foreach ($post_emails as $email) {

            $recipients = EmailRecipient::with('user', 'email')
                ->where(['email_id' => $email->id, 'try' => 0])
                ->get();

            if (count($recipients) > 0) {
                foreach ($recipients as $recipient) {
                    try {
                        Mail::to($recipient->user->email)->send(new BulkEmail($recipient->user?->first_name . ' ' . $recipient->user?->last_name, $recipient->email->subject, $recipient->email->message));

                        $recipient->update(['try' => 1, 'is_sent' => 1]);
                    } catch (\Exception $e) {
                        logger($e->getMessage());
                        $recipient->update(['try' => 1]);
                    }
                }
            }
        }
    }
}
