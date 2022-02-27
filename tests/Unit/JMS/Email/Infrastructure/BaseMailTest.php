<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Email\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JMS\Email\Infrastructure\Mail\BaseMail;

final class BaseMailTest extends TestCase
{
    use WithFaker;

    function test_base_mail_build()
    {
        $mail = new BaseMail();

        $result = $mail->build();

        $this->assertInstanceOf(BaseMail::class, $result);
    }

}