# API Editor - Clean Architecture with Laravel

This repository is built for Laravel 11. It follows Clean Architecture principles, 
organizing business logic and infrastructure code inside the `src` directory. 
This approach promotes separation of concerns, maintainability, and testability.

## Project Structure

```
src/
├── Application/              # Application layer (Use Cases)
│   ├── Actions/              # Business logic and use cases
│   └── DataTransferObjects/  # DTOs for data transfer
├── Domain/                   # Domain layer (Business Rules)
│   ├── Contracts/            # Interfaces and contracts
│   ├── Entities/             # Domain entities
│   └── Enums/                # Enumerations
├── Infrastructure/           # Infrastructure layer (Framework)
│   ├── Controllers/          # API Controllers
│   ├── Exceptions/           # Exception handling
│   ├── Persistences/         # Database implementations
│   ├── Requests/             # Form requests validation
│   └── Responses/            # API resources/responses
└── Shared/                   # Shared Components
    ├── Config/               # Configuration files
    ├── Database/             # Migrations and seeders
    ├── Providers/            # Service providers
    ├── Resources/            # Views and assets
    └── Routes/               # API and web routes
```

## Installation

1. Create a new Laravel project:
```bash
composer create-project laravel/laravel your-project-name
```

2. Copy the `src` directory into your project's root folder.

3. Update your `composer.json` to add the necessary autoload paths:
```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Src\\": "src/",
        "Database\\Factories\\": "src/Shared/Database/Factories/",
        "Database\\Seeders\\": "src/Shared/Database/Seeders/"
    },
    "files": [
        "src/Infrastructure/Helpers/helpers.php"
    ]
}
```

4. Install required dependencies:
```bash
composer require darkaonline/l5-swagger swagger-api/swagger-ui setasign/fpdf
```

5. Update your `bootstrap/providers.php` to register the service providers:
```php
return [
    DependencyInjectionServiceProvider::class,
    EventServiceProvider::class,
    RouteServiceProvider::class,
    SourceServiceProvider::class,
    L5Swagger\L5SwaggerServiceProvider::class,
];
```

6. Publish the l5-swagger configuration:
```bash
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

7. Update `config/l5-swagger.php` to point to the correct views directory:
```php
'views' => base_path('src/Infrastructure/Resources/views'),
```

8. Generate the API documentation:
```bash
php artisan l5-swagger:generate
```

## Required Packages

The following packages are required in addition to Laravel's default packages:

```json
{
    "require": {
        "darkaonline/l5-swagger": "^8.6",
        "swagger-api/swagger-ui": "^5.19"
    }
}
```

## Usage

1. Routes are defined in:
   - `src/Shared/Routes/api.php` for API routes
   - `src/Shared/Routes/web.php` for web routes

2. API Documentation is available at:
   - Swagger UI: `http://your-app/api/documentation`
   - ReDoc: `http://your-app/docs/redoc`

3. Main components:
   - Controllers are in `src/Infrastructure/Controllers`
   - Business logic is in `src/Application/Actions`
   - Domain entities are in `src/Domain/Entities`
   - Database models are in `src/Infrastructure/Persistences/Models`

## Development

1. Follow the directory structure to maintain separation of concerns
2. Put business logic in Application/Actions
3. Define interfaces in Domain/Contracts
4. Implement interfaces in Infrastructure layer
5. Use DTOs for data transfer between layers
6. Add API documentation using OpenAPI annotations in controllers

## Testing

Tests should follow the same structure as the source code:

```bash
tests/
├── Unit/          # Unit tests for Domain and Application layers
├── Integration/   # Integration tests for Infrastructure layer
└── Feature/       # Feature tests for API endpoints
```

## Contributing

1. Create a new branch for your feature
2. Follow the existing architecture and patterns
3. Add tests for new functionality
4. Update API documentation if endpoints change
5. Submit a pull request

## License

This project is open-sourced software licensed under the MIT license.
