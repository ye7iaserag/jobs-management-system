# What is this?

This repo contains a sample project for component based bounded context hexagonal architecture job management system.

## Technical Decisions and Implementation details:

- Laravel Framework is used in this project.
- Symfony Messenger message bus used for command, query and event busses.
- Command handlers are synonyms to application layer services.
- Hexagonal architecture is used with CQRS were domains expose ports for outer layers to implement.
- Commands do not return data while queries do (CQRS standard), thus it's infrastructure role to generate and return UUIDs for commands.
- Authorization checks are done in infrastructure for application layer commands/queries to be decoupled and reusable by clients other than HTTP (like terminals or event subscribers) instead of having command authorizer middlewares.
- Cross-cutting concernes are handled in a shared context.
- Each context is standalone and does not know about sibiling contexts other than shared context.
- RabbitMQ is used as a message broker.
- Development docker and docker compose files are present in the repo.
- `php artisan rabbitmq:consume` is used with supervisord to scale queue workers inside a container through configuration.
- Unit tests cover %100.
- docker compose includes 2 services that use the same app image (api and watcher).
- Kubernetes implementation is not by any means production ready but rather a demonestration (includes debug and troubleshoot tools like phpmyadmin, mailhog and rabbitmq manager), also I couldn't upload the app image to a registry since development image is over 400MB in size.

## What's not implemented:
- Some cross-cutting concerns like pagination.
- TimeStamps for models and entities.


