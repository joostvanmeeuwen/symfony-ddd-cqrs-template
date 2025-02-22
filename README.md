# Album Manager Demo

A demo project showcasing DDD, CQRS, and Hexagonal Architecture using Symfony 7.

## Architecture

The project follows hexagonal architecture with:

- **Domain Layer**: Core business logic and domain models
- **Application Layer**: Application services, commands, and queries (CQRS)
- **Infrastructure Layer**: Technical implementations (Doctrine, etc.)
- **User Interface Layer**: REST API and Web interface

## Features

- CQRS implementation using Symfony Messenger
- REST API with OpenAPI/Swagger documentation
- Simple web interface
- Postgresql database
- Docker environment

## Installation

1. Clone the repository
2. Start Docker containers:
```bash
docker compose up -d
```

3. Install dependencies:
```bash
docker compose exec php composer install
```

4. Create database and run migrations:
```bash
docker compose exec php bin/console doctrine:migrations:migrate
```

## Usage

- Web Interface: `http://localhost:8085`
- REST API: `http://localhost:8085/api/v1`
- API Documentation: `http://localhost:8085/api/docs`

### REST API Endpoints

- `POST /api/v1/albums` - Create new album
- `GET /api/v1/albums` - List albums with pagination and sorting

## Development

The project uses:
- PHP 8.4
- Symfony 7.2
- PostgreSQL
- Doctrine ORM
- Symfony Messenger for CQRS