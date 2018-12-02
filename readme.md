# Client contact

This is simple client contact app on PHP.

# Dependencies

PHP >= 5.6

-   **Lumen:** Framework
-   **PHP Unit:** Testing
-   **Swagger-Php:** Open Api documentation generator

# Running project

1.  First of all install dependencies and run migrations.

    ```
    composer install && composer migrate
    ```

2.  Start main app. App will start on [http://localhost:8000](http://localhost:8000).

    ```
    composer start
    ```

3.  Client side availabe here [http://localhost:8000/client/index.html](http://localhost:8000/client/index.html).

4.  Generate access token for admin user by running:

```
    php artisan token:generate 1
```

Use this token to authorize.

# Architecture

### Migration

App supports migrations to easy maintain and scale databse. Lumen provides out of the box support that.
To create new migration run:

```
php artisan make:migration MigrationName
```

To apply migration run:

```
php artisan migrate
```

### Models

There are three models

-   **Client:** Stores client data.
-   **ClientContacts:** Stores client contact data.
-   **Token:** Stores token data.

### Config

All configuration fies stored in config folder. By default configs set up for local usage. To override defaults just copy `.env.example` file as `.env` and write new configs there.

### Tests

App supports unit testing. Tests folder contains all test classes. Database transactions used for databse testing, so no data will be currapted on local server. By far is only messages test. To run tests you can use command:

```
composer test
```

# Features

### Authentication

You can generate access token in console. This simplification made for ease of demonstration. After that user will get access token, and can make requests to server.

Client can pass Authorization header like this.

```
Authorization: [TOKEN_HERE]
```

### CRUD

Client and Client Contact supports basic CRUD operations.

### Import csv

Client supports batch import from CSV file. Duplicates and invalid data will be ignored.

# Documentation

Project API supports versioning.

API documentation: [http://localhost:8000/swagger/](http://localhost:8000/swagger/).
