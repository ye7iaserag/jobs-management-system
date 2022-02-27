<?php

namespace App\Providers;

use Shared\Domain\Bus\Command\CommandBus;
use Shared\Domain\Bus\Event\EventBus;
use Shared\Domain\Bus\Query\QueryBus;
use Shared\Domain\Port\UuidGenerator;
use Shared\Infrastructure\Bus\Messenger\MessengerCommandBus;
use Shared\Infrastructure\Bus\Messenger\MessengerEventBus;
use Shared\Infrastructure\Bus\Messenger\MessengerQueryBus;
use Shared\Infrastructure\Service\RamseyUuidGenerator;
use Illuminate\Support\ServiceProvider;
use Shared\Domain\Port\AuthService as AuthServiceInterface;
use Shared\Infrastructure\Service\AuthService;
use Shared\Domain\Bus\Event\ConnectionFactory;
use Shared\Infrastructure\Bus\Messenger\RabbitMQConnectionFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            EventBus::class,
            function ($app) {
                return new MessengerEventBus($app->tagged('domain_event_subscriber'), new RabbitMQConnectionFactory);
            }
        );

        $this->app->bind(
            QueryBus::class,
            function ($app) {
                return new MessengerQueryBus($app->tagged('query_handler'));
            }
        );

        $this->app->bind(
            CommandBus::class,
            function ($app) {
                return new MessengerCommandBus($app->tagged('command_handler'));
            }
        );

        $this->app->bind(
            ConnectionFactory::class,
            RabbitMQConnectionFactory::class
        );


        $this->app->bind(
            UuidGenerator::class,
            RamseyUuidGenerator::class
        );

        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class
        );

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
