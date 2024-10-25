<?php

namespace Domain\Mail;

use Domain\Contracts\IEmailSender;
use Exception;
use Illuminate\Support\Facades\Mail;

class EmailSender implements IEmailSender
{
    /**
     * Sends an email.
     *
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param array $attachments
     * @return bool
     */
    public function send(string $to, string $subject, string $body, array $attachments = []): bool
    {
        try {
            $data = [
                'body' => $body,
                'subject' => $subject,
            ];
            
            Mail::to($to)->send(new EmailTemplate($data, $attachments));

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
