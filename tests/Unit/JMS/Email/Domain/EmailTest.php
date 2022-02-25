<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Email\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JMS\Email\Domain\Entity\Email;
use JMS\Email\Domain\ValueObject\EmailAddress;
use JMS\Email\Domain\ValueObject\EmailBody;
use JMS\Email\Domain\ValueObject\EmailId;
use JMS\Email\Domain\ValueObject\EmailSubject;

final class EmailTest extends TestCase
{
    use WithFaker;

    function test_create_email()
    {
        $emailId = new EmailId($this->faker->uuid());
        $emailAddress = new EmailAddress($this->faker->email());
        $emailSubject = new EmailSubject($this->faker->name());
        $emailBody = new EmailBody($this->faker->name());

        $email = new Email($emailId, $emailAddress, $emailSubject, $emailBody);

        $this->assertEquals($emailId->value(), $email->id()->value());
        $this->assertEquals($emailAddress->value(), $email->email()->value());
        $this->assertEquals($emailSubject->value(), $email->subject()->value());
        $this->assertEquals($emailBody->value(), $email->body()->value());
    }

    function test_hydrate_email()
    {
        $id = $this->faker->uuid();
        $address = $this->faker->email();
        $subject = $this->faker->name();
        $body = $this->faker->name();

        $email = Email::fromPrimitives($id, $address, $subject, $body);

        $this->assertEquals($id, $email->id()->value());
        $this->assertEquals($address, $email->email()->value());
        $this->assertEquals($subject, $email->subject()->value());
        $this->assertEquals($body, $email->body()->value());
    }
    
}
