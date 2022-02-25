<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\DeleteJob\DeleteJobByIdCommand;
use Tests\TestCase;

final class DeleteJobByIdCommandTest extends TestCase
{
    use WithFaker;

    function test_create_delete_job_by_id_command()
    {
        $id = $this->faker->uuid();

        $command = new DeleteJobByIdCommand($id);

        $this->assertEquals($id, $command->id());
    }

}