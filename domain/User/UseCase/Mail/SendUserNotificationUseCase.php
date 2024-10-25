<?php

namespace Domain\User\UseCase\Mail;

use Domain\Contracts\IEmailSender;

class SendUserNotificationUseCase {
    protected IEmailSender $emailSender;
    
    public function __construct(IEmailSender $emailSender) {
        $this->emailSender = $emailSender;
    }
    
    public function execute(array $data) {
        $this->emailSender->send($data['to'], $data['subject'], $data['body']);
    }
}
