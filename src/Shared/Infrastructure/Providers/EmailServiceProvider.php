<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Providers;


use Illuminate\Support\ServiceProvider;
use JMS\Email\Domain\Port\EmailSender;
use JMS\Email\Infrastructure\Service\LaravelEmailSender;
use JMS\Email\Application\Command\Send\SendEmailCommandHandler;
use JMS\Email\Application\Subscriber\SendEmailSubscriber;

final class EmailServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            EmailSender::class,
            LaravelEmailSender::class
        );

        $this->app->tag(
            SendEmailCommandHandler::class,
            'command_handler'
        );

        $this->app->tag(
            SendEmailSubscriber::class,
            'domain_event_subscriber'
        );
    }

}
