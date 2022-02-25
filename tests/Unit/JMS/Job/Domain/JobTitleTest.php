<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JMS\Job\Domain\ValueObject\{ JobTitle };

final class JobTitleTest extends TestCase
{
    use WithFaker;

    function test_create_job_title()
    {
        $title = $this->faker->name();
        $jobTitle = new JobTitle($title);

        $this->assertEquals($title, $jobTitle->value());
    }

    function test_create_job_title_min_length()
    {
        $this->expectException(\InvalidArgumentException::class);
        new JobTitle('');
    }

    function test_create_job_title_max_length()
    {
        $this->expectException(\InvalidArgumentException::class);
        new JobTitle(random_bytes(101));
    }
}
