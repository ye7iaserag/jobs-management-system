<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Shared\Domain\Bus\Command\CommandBus;
use Tests\TestCase;

final class DeleteJobCommandTest extends TestCase
{
    use WithFaker;

    function test_delete_job_command()
    {
        $this->mock(CommandBus::class, fn ($mock) => $mock->shouldReceive('dispatch')->once()->andReturn(null));

        $this->artisan('job:delete 1')->assertSuccessful();
    }

}
