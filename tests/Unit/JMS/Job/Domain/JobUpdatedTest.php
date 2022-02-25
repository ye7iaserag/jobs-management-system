<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JMS\Job\Domain\Event\JobUpdated;

final class JobUpdatedTest extends TestCase
{
    use WithFaker;

    function test_create_job_updated()
    {
        $uuid = $this->faker->uuid();
        $payload = [];
        $eventUuid = $this->faker->uuid();
        $occuredOn = $this->faker->name();

        $jobUpdated = JobUpdated::fromPrimitives($uuid, $payload, $eventUuid, $occuredOn);

        $this->assertEquals($uuid, $jobUpdated->aggregateId());
        $this->assertEquals($payload, $jobUpdated->payload());
        $this->assertEquals($eventUuid, $jobUpdated->eventId());
        $this->assertEquals($occuredOn, $jobUpdated->occurredOn());
    }

    function test_job_updated_to_primitives()
    {
        $uuid = $this->faker->uuid();
        $payload = [];
        $eventUuid = $this->faker->uuid();
        $occuredOn = $this->faker->name();

        $jobUpdated = JobUpdated::fromPrimitives($uuid, $payload, $eventUuid, $occuredOn);

        $primitives = $jobUpdated->toPrimitives();
        $this->assertEquals($uuid, $primitives[0]);
        $this->assertEquals($payload, $primitives[1]);
        $this->assertEquals($eventUuid, $primitives[2]);
        $this->assertEquals($occuredOn, $primitives[3]);
    }

    function test_job_updated_name() {
        $jobUpdated = new JobUpdated($this->faker->uuid(), [], $this->faker->uuid(), );
        $this->assertEquals(JobUpdated::EVENT_NAME, $jobUpdated->eventName($this->faker->name()));
    }

    
    
}
