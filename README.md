
Technical Decisions and Implementation details:

- Laravel Framework is used in this project.
- Symfony Messenger message bus used for command, query and even busses.
- Command handlers are synonyms to application layer services.
- Hexagonal architecture is used with CQRS were the domain in the inner cirlce then application then infra, each layer doesn't know about the any layer above it but exposes ports for outer layers to implement.
- Commands do not return data while queries do (CQRS standard), thus it's infrastructure role to generate and return UUIDs for commands.
- Authorization checks are done in infrastructure for application layer commands/queries to be (decoupled) reusable by clients other than HTTP (like terminals or event subscribers) instead of having command authorizer middleware.
- Cross-cutting concernes are handled in a shared context.
- Each context is standalone and does not know about sibiling contexts other than shared context.
- RabbitMQ is used as a message broker.
- Development docker and docker compose files are present in the repo.
- `php artisan rabbitmq:consume` is used with supervisord to scale queue workers inside a container through configuration.


