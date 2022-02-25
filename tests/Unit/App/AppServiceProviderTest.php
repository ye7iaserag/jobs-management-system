<?php

declare(strict_types=1);

namespace Tests\Unit\App;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Shared\Domain\Bus\Command\CommandBus;
use Shared\Domain\Bus\Event\EventBus;
use Shared\Domain\Bus\Query\QueryBus;

final class AppServiceProviderTest extends TestCase
{
    use WithFaker;

    function test_app_service_provider()
    {
        $eventBus = $this->app->make(EventBus::class);

        $commandBus = $this->app->make(CommandBus::class);

        $queryBus = $this->app->make(QueryBus::class);

        $this->assertInstanceOf(EventBus::class, $eventBus);
        $this->assertInstanceOf(CommandBus::class, $commandBus);
        $this->assertInstanceOf(QueryBus::class, $queryBus);
    }
}
