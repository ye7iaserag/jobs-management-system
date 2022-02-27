<?php

namespace Shared\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use JMS\Auth\Application\Query\ListUsers\ListUsersQueryHandler;
use JMS\Auth\Domain\Port\JwtRepository as JwtRepositoryInterface;
use JMS\Auth\Infrastructure\Service\JwtRepository;
use JMS\Auth\Domain\Port\UserRepository as UserRepositoryInterface;
use JMS\Auth\Infrastructure\Persistence\Eloquent\UserRepository;
use JMS\Auth\Application\Query\Login\LoginQueryHandler;
use JMS\Auth\Domain\Port\HashService as HashServiceInterface;
use JMS\Auth\Infrastructure\Service\HashService;
use JMS\Auth\Application\Subscriber\JobCreatedSubscriber;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'Shared\Infrastructure\Models\Model' => 'Shared\Infrastructure\Policies\ModelPolicy',
    ];

    public function register()
    {
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
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->registerPolicies();

        //
    }
}
