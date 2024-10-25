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
            // Prepare the data for the email
            $data = [
                'body' => $body,
                'subject' => $subject,
                // Other data you might need
            ];
            
            // Send the email
            Mail::to($to)->send(new EmailTemplate($data, $attachments));
            
            return true; // Email sent successfully
        } catch (Exception $e) {
            Log::error('Error sending email: ' . $e->getMessage());
            return false; // Email not sent
        }
    }
}
