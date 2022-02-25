<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JMS\Job\Domain\ValueObject\{ JobOwnerId };

final class JobOwnerIdTest extends TestCase
{
    use WithFaker;

    function test_create_job_owner_id()
    {
        $uuid = $this->faker->uuid();
        $JobOwnerId = new JobOwnerId($uuid);

        $this->assertEquals($uuid, $JobOwnerId->value());
    }

    function test_job_owner_id_expects_uuid()
    {
        $this->expectException(\InvalidArgumentException::class);
        new JobOwnerId($this->faker->string());
    }
}