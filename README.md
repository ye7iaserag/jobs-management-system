# What is this?

This repo contains a sample project for component based bounded context hexagonal architecture job management system.

### Commands:
- Use `php artisan test --coverage` to run tests and check coverage.
- Use `docker compose build` and `docker compose up` to run compose file (docker compose >= v2).
- Use `kubectl` with Ingress to run kubernetes cluster.

### Exposed ports:
| Http service | Port |
| ----------- | ----------- |
| api | `80` |
| phpmyadmin | `8080` |
| rabbitmq manager | `15672` |
| mailhog | `8025` |

## Technical Decisions and Implementation details:

- Laravel Framework is used in this project.
- Symfony Messenger message bus used for command, query and event busses.
- Command handlers are synonyms to application layer services.
- Hexagonal architecture is used with CQRS were domains expose ports for outer layers to implement.
- Commands do not return data while queries do (CQRS standard), thus it's infrastructure role to generate and return UUIDs for commands.
- Authorization checks are done in infrastructure for application layer commands/queries to be decoupled and reusable by clients other than HTTP (like terminals or event subscribers) instead of having command authorizer middlewares.
- Building on the previous point, console commands were added for all jobs to demonstrate the reusability of commands and queries in application layer.
- Cross-cutting concernes are handled in a shared context.
- Each context is standalone and does not know about sibiling contexts other than shared context.
- RabbitMQ is used as a message broker.
- Development docker and docker compose files are present in the repo.
- `php artisan rabbitmq:consume` is used with supervisord to scale queue workers inside a container through configuration.
- Unit tests cover %100 or code.
- Feature tests cover all endpoints in the app.
- docker compose includes 2 services that use the same app image (api and watcher).
- Dockerfile is for development only and thus no `.dockerignore` file and the code is included as a bind mount and not copied to the image.
- Kubernetes implementation is not by any means production ready but rather a demonestration (includes debug and troubleshoot tools like phpmyadmin, mailhog and rabbitmq manager), also I couldn't upload the app image to a registry since development image is over 400MB in size.

## What's not implemented:
- Some cross-cutting concerns like pagination.
- TimeStamps for models and entities.


