<?php

namespace Shared\Infrastructure\Console\Commands;

use Illuminate\Console\Command;
use Shared\Domain\Bus\Event\ConnectionFactory;
use Symfony\Component\Messenger\Worker;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Messenger\EventListener\StopWorkerOnTimeLimitListener;

class RabbitMQConsumeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consume {timeLimit?}';

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
        $this->factory = app()->make(ConnectionFactory::class);

        $messageBus = new MessageBus(
            [
                $this->factory->makeHandleMessageMiddleware()
            ]
        );

        $eventDispatcher = new EventDispatcher();
        
        $timeLimit = $this->argument('timeLimit');

        if (!is_null($timeLimit)) {
            $eventDispatcher->addSubscriber(new StopWorkerOnTimeLimitListener($timeLimit));
        }
        $worker = new Worker([$this->factory->getReceiver()], $messageBus, $eventDispatcher);
        $options = [
            'sleep' => 3 * 1000000,
            'queues' => ['messages']
        ];
        $worker->run($options);
        return 0;
    }
}
