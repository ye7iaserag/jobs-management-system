<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JMS\Job\Domain\ValueObject\{ JobDescription };

final class JobDescriptionTest extends TestCase
{
    use WithFaker;

    function test_create_job_description()
    {
        $description = $this->faker->name();
        $jobDescription = new JobDescription($description);

        $this->assertEquals($description, $jobDescription->value());
    }

    function test_create_job_description_min_length()
    {
        $this->expectException(\InvalidArgumentException::class);
        new JobDescription('');
    }

    function test_create_job_description_max_length()
    {
        $this->expectException(\InvalidArgumentException::class);
        new JobDescription(random_bytes(201));
    }
}
