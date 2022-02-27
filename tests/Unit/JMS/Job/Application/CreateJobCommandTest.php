<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\Command\CreateJob\CreateJobCommand;
use Tests\TestCase;

final class CreateJobCommandTest extends TestCase
{
    use WithFaker;

    function test_create_create_job_command()
    {
        $id = $this->faker->uuid();
        $title = $this->faker->name();
        $description = $this->faker->name();
        $ownerId = $this->faker->uuid();

        $command = new CreateJobCommand($id, $title, $description, $ownerId);

        $this->assertEquals($id, $command->id());
        $this->assertEquals($title, $command->title());
        $this->assertEquals($description, $command->description());
        $this->assertEquals($ownerId, $command->ownerId());
    }

}