<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Shared\Domain\Bus\Query\Query;
use Shared\Domain\Bus\Query\QueryHandler;
use Shared\Infrastructure\Bus\Messenger\MessengerQueryBus;
use Shared\Infrastructure\Bus\Messenger\QueryNotRegistered;
use Shared\Domain\Bus\Query\Response;

class QueryResponseExample implements Response {}
class QueryExample implements Query {}
class QueryHandlerExample implements QueryHandler {public function __invoke(QueryExample $command){ return new QueryResponseExample();}}

final class MessengerQueryBusTest extends TestCase
{
    use WithFaker;

    function test_messenger_query_bus_ask()
    {
        $queryBus = new MessengerQueryBus([new QueryHandlerExample]);

        $result = $queryBus->ask(new QueryExample);

        $this->assertInstanceOf(QueryResponseExample::class, $result);
    }

    function test_messenger_query_bus_handler_not_found()
    {
        $queryBus = new MessengerQueryBus([]);

        $this->expectException(QueryNotRegistered::class);

        $queryBus->ask(new class implements Query{});
    }
    
}
