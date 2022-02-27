<?php

declare(strict_types=1);

namespace JMS\Email\Application\Command\Send;

use Shared\Domain\Bus\Command\Command;

final class SendEmailCommand implements Command
{
    private string $id;
    private string $email;
    private string $subject;
    private string $body;

    public function __construct(string $id, string $email, string $subject, string $body)
    {
        $this->id = $id;
        $this->email = $email;
        $this->subject = $subject;
        $this->body = $body;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function subject(): string
    {
        return $this->subject;
    }

    public function body(): string
    {
        return $this->body;
    }
}
