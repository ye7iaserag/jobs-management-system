<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JMS\Job\Domain\Event\JobCreated;

final class JobCreatedTest extends TestCase
{
    use WithFaker;

    function test_create_job_created()
    {
        $uuid = $this->faker->uuid();
        $payload = [];
        $eventUuid = $this->faker->uuid();
        $occuredOn = $this->faker->name();

        $jobCreated = JobCreated::fromPrimitives($uuid, $payload, $eventUuid, $occuredOn);

        $this->assertEquals($uuid, $jobCreated->aggregateId());
        $this->assertEquals($payload, $jobCreated->payload());
        $this->assertEquals($eventUuid, $jobCreated->eventId());
        $this->assertEquals($occuredOn, $jobCreated->occurredOn());
    }

    function test_job_created_to_primitives()
    {
        $uuid = $this->faker->uuid();
        $payload = [];
        $eventUuid = $this->faker->uuid();
        $occuredOn = $this->faker->name();

        $jobCreated = JobCreated::fromPrimitives($uuid, $payload, $eventUuid, $occuredOn);

        $primitives = $jobCreated->toPrimitives();
        $this->assertEquals($uuid, $primitives[0]);
        $this->assertEquals($payload, $primitives[1]);
        $this->assertEquals($eventUuid, $primitives[2]);
        $this->assertEquals($occuredOn, $primitives[3]);
    }

    function test_job_created_name() {
        $jobCreated = new JobCreated($this->faker->uuid(), [], $this->faker->uuid(), );
        $this->assertEquals(JobCreated::EVENT_NAME, $jobCreated->eventName($this->faker->name()));
    }

    
    
}
