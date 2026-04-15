# Shareholding Structure

This project is an initial exploration of Symfony.

## Getting Started

1. Make sure you have Docker Compose installed. You can find the installation guide here: https://docs.docker.com/compose/install/
2. Run `docker compose build --no-cache` to build fresh images.
3. Run `docker compose up --pull always -d --wait` to start the project.
4. Run `docker compose exec php composer install` to install project dependencies.
5. This project includes only the API layer. You can access `https://localhost/ping` to verify that everything is working correctly.
6. Finally, run `docker compose down --remove-orphans` to stop all containers.

## Implementation Details

CRUD operations were implemented for Organizations and Associates.
The project follows clean architecture principles based on the Symfony documentation.
Routes are defined within their respective Controllers and can also be listed using the command:
    `docker compose exec php php bin/console debug:router`
The API follows RESTful design principles.

## Additional Notes

- This Docker setup is based on the official Symfony Docker configuration. More details can be found here: https://github.com/dunglas/symfony-docker
- The most commonly used commands during development are:
  - `docker compose exec php` to interact with the PHP container
  - `docker compose exec database psql -U app -d app` to access the database