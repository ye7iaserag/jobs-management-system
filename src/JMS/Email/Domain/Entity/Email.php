<?php

declare(strict_types=1);

namespace JMS\Email\Domain\Entity;

use JMS\Email\Domain\ValueObject\ { EmailId, EmailAddress, EmailSubject, EmailBody };

final class Email
{
    private EmailId $id;
    private EmailAddress $email;
    private EmailSubject $subject;
    private EmailBody $body;

    public function __construct(EmailId $id, EmailAddress $email, EmailSubject $subject, EmailBody $body)
    {
        $this->id = $id;
        $this->email = $email;
        $this->subject = $subject;
        $this->body = $body;
    }

    public static function fromPrimitives(string $id, string $email, string $subject, string $body): self
    {
        return new self(
            EmailId::fromValue($id),
            EmailAddress::fromValue($email),
            EmailSubject::fromValue($subject),
            EmailBody::fromValue($body)
        );
    }

    public function id(): EmailId
    {
        return $this->id;
    }

    public function email(): EmailAddress
    {
        return $this->email;
    }

    public function subject(): EmailSubject
    {
        return $this->subject;
    }

    public function body(): EmailBody
    {
        return $this->body;
    }
}
