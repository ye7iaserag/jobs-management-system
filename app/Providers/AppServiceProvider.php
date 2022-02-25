<?php

namespace App\Providers;

use Shared\Domain\Bus\Command\CommandBus;
use Shared\Domain\Bus\Event\EventBus;
use Shared\Domain\Bus\Query\QueryBus;
use Shared\Domain\Port\UuidGenerator;
use Shared\Infrastructure\Bus\Messenger\MessengerCommandBus;
use Shared\Infrastructure\Bus\Messenger\MessengerEventBus;
use Shared\Infrastructure\Bus\Messenger\MessengerQueryBus;
use Shared\Infrastructure\Services\RamseyUuidGenerator;
use Illuminate\Support\ServiceProvider;
use JMS\Auth\Application\ListUsers\ListUsersQueryHandler;
use Shared\Domain\Port\AuthService as AuthServiceInterface;
use Shared\Infrastructure\Services\AuthService;

use JMS\Auth\Domain\JwtRepository as JwtRepositoryInterface;
use JMS\Auth\Infrastructure\JwtRepository;
use JMS\Auth\Domain\UserRepository as UserRepositoryInterface;
use JMS\Auth\Infrastructure\Persistence\Eloquent\UserRepository;
use JMS\Auth\Application\Login\LoginQueryHandler;
use JMS\Auth\Domain\HashService as HashServiceInterface;
use JMS\Auth\Infrastructure\HashService;
use JMS\Auth\Application\Subscriber\JobCreatedSubscriber;
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
            UuidGenerator::class,
            RamseyUuidGenerator::class
        );

        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class
        );

        $this->app->bind(
            JwtRepositoryInterface::class,
            JwtRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            HashServiceInterface::class,
            HashService::class
        );

        $this->app->tag(
            LoginQueryHandler::class,
            'query_handler'
        );

        $this->app->tag(
            ListUsersQueryHandler::class,
            'query_handler'
        );

        $this->app->tag(
            JobCreatedSubscriber::class,
            'domain_event_subscriber'
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
