<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class BulkEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $name;
    public $subject;
    public $body;
    public $body_message;

    public function __construct($name, $subject, $body)
    {
        $this->name = $name;
        $this->subject = $subject;
        $this->body_message = $body;
    }

    public function envelope()
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function content()
    {
        return new Content(
            view: 'email.default',
        );
    }

    public function attachments()
    {
        return [];
    }
}
