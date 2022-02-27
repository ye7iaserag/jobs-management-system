<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\Command\UpdateJob\UpdateJobCommand;
use Tests\TestCase;

final class UpdateJobCommandTest extends TestCase
{
    use WithFaker;

    function test_create_update_job_command()
    {
        $id = $this->faker->uuid();
        $title = $this->faker->name();
        $description = $this->faker->name();

        $command = new UpdateJobCommand($id, $title, $description);

        $this->assertEquals($id, $command->id());
        $this->assertEquals($title, $command->title());
        $this->assertEquals($description, $command->description());
    }

}