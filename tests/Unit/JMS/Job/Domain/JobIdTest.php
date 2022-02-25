<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JMS\Job\Domain\ValueObject\{ JobId };

final class JobIdTest extends TestCase
{
    use WithFaker;

    function test_create_job_id()
    {
        $uuid = $this->faker->uuid();
        $jobId = new JobId($uuid);

        $this->assertEquals($uuid, $jobId->value());
    }

    function test_job_id_expects_uuid()
    {
        $this->expectException(\InvalidArgumentException::class);
        new JobId($this->faker->string());
    }
}