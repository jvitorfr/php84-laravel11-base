<?php

namespace Domain\Contracts;

interface IEmailSender
{
    public function send(string $to, string $subject, string $body, array $attachments = []): bool;
}
