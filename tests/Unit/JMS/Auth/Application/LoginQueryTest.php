<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Application\Query\Login\LoginQuery;
use Tests\TestCase;

final class LoginQueryTest extends TestCase
{
    use WithFaker;

    function test_create_login_query()
    {
        $email = $this->faker->email();
        $password = $this->faker->name();
        $query = new LoginQuery($email, $password);

        $this->assertEquals($email, $query->email());
        $this->assertEquals($password, $query->password());
    }

}