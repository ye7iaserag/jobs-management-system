<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;
use JMS\Job\Infrastructure\Persistence\Eloquent\JobModelFactory;

use function PHPUnit\Framework\assertInstanceOf;

final class JobModelFactoryTest extends TestCase
{
    use WithFaker;

    function test_create_job_model_factory()
    {
        $factory = new JobModelFactory();
        $definition = $factory->definition();

        $this->assertInstanceOf(Factory::class, $factory);
        $this->assertIsArray($definition);
        $this->assertArrayHasKey('id', $definition);
        $this->assertArrayHasKey('title', $definition);
        $this->assertArrayHasKey('description', $definition);
        $this->assertArrayHasKey('user_id', $definition);
    }

    
    
}
