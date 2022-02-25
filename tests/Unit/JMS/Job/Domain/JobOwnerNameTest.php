<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JMS\Job\Domain\ValueObject\{ JobOwnerName };

final class JobOwnerNameTest extends TestCase
{
    use WithFaker;

    function test_create_job_owner_name()
    {
        $name = $this->faker->name();
        $jobOwnerName = new JobOwnerName($name);

        $this->assertEquals($name, $jobOwnerName->value());
    }

    function test_create_job_owner_name_min_length()
    {
        $this->expectException(\InvalidArgumentException::class);
        new JobOwnerName('');
    }

    function test_create_job_owner_name_max_length()
    {
        $this->expectException(\InvalidArgumentException::class);
        new JobOwnerName(random_bytes(101));
    }
}
