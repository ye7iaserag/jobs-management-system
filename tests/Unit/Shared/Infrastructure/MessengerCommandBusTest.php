<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure;

use Exception;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Shared\Infrastructure\Bus\Messenger\MessengerCommandBus;
use Shared\Domain\Bus\Command\Command;
use Shared\Domain\Bus\Command\CommandHandler;
use Shared\Infrastructure\Bus\Messenger\CommandNotRegistered;

class CommandExceptionExample extends Exception {}
class CommandExample implements Command {}
class CommandHandlerExample implements CommandHandler {public function __invoke(CommandExample $command){ throw new CommandExceptionExample();}}

final class MessengerCommandBusTest extends TestCase
{
    use WithFaker;

    function test_messenger_command_bus_handler_not_found()
    {
        $commandBus = new MessengerCommandBus([]);

        $this->expectException(CommandNotRegistered::class);

        $commandBus->dispatch(new class implements Command {});
    }

    function test_messenger_command_bus_handler_error()
    {
        $commandBus = new MessengerCommandBus([new CommandHandlerExample]);

        $this->expectException(CommandExceptionExample::class);

        $commandBus->dispatch(new CommandExample);
    }
    
}
