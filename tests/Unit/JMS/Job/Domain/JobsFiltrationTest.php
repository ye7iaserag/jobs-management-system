<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JMS\Job\Domain\DTO\JobsFiltration;
use JMS\Job\Domain\ValueObject\{ JobOwnerId };

final class JobsFiltrationTest extends TestCase
{
    use WithFaker;

    function test_create_jobs_filtration()
    {
        $jobOwnerId = new JobOwnerId($this->faker->uuid());

        $jobsFiltration = new JobsFiltration($jobOwnerId);

        $this->assertEquals($jobOwnerId->value(), $jobsFiltration->ownerId()->value());
    }

}
