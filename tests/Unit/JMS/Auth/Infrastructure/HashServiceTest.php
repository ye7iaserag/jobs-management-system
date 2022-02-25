<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Domain\ValueObject\UserPassword;
use JMS\Auth\Infrastructure\HashService;
use Tests\TestCase;

final class HashServiceTest extends TestCase
{
    use WithFaker;

    function test_hash_check()
    {
        $service = new HashService();

        $result = $service->check(new UserPassword('Test$tr1ng'), new UserPassword('$2a$12$.gwiMlUoi1w7hWuFNGpaZuhNX/UoMj/ev3lRQxdrBe/EO09nMsugK'));

        $this->assertTrue($result);
    }

}
