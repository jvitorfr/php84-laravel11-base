<?php

namespace Domain\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailTemplate extends Mailable
{
    use Queueable;
    use SerializesModels;

    public array $data;
    public $attachments;

    public function __construct(array $data, array $attachments = [])
    {
        $this->data = $data;
        $this->attachments = $attachments;
    }

    public function build(): EmailTemplate
    {
        $email = $this->subject($this->data['subject'])
            ->view('emails.email_template')
            ->with(['body' => $this->data['body']]);


        foreach ($this->attachments as $attachment) {
            $email->attach($attachment);
        }

        return $email;
    }
}
