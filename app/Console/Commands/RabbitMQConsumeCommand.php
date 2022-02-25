<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Messenger\Worker;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\Connection;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpReceiver;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Shared\Infrastructure\Bus\Messenger\CallableFirstParameterExtractor;
use Shared\Infrastructure\Bus\Messenger\RabbitMQConnectionFactory;

class RabbitMQConsumeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $factory = app()->make(RabbitMQConnectionFactory::class);
        $messageBus = new MessageBus(
            [
                $factory->makeHandleMessageMiddleware()
            ]
        );
        $worker = new Worker([$factory->getReceiver()], $messageBus, new EventDispatcher());
        $options = [
            'sleep' => 3 * 1000000,
            'queues' => ['messages']
        ];
        $worker->run($options);
        return 0;
    }
}
