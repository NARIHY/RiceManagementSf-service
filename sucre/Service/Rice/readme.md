# Rice Management API

## Overview

The Rice Management API is a RESTful service designed to manage different types of rice. It provides endpoints for CRUD (Create, Read, Update, Delete) operations, allowing users to manage rice types efficiently.

## Features

- **List all rice types**
- **Retrieve a specific rice type by ID**
- **Create a new rice type**
- **Update an existing rice type**
- **Delete a rice type**

## Technologies Used

- **PHP** (Laravel Framework)
- **OpenAPI** (Swagger for API documentation)
- **MariaDb** (Database)
- **Laravel Sanctum** (Authentication)

## API Endpoints

### List All Rice Types

- **GET** `/api/v1/Entreprise/Type-Rice`

### Retrieve a Specific Rice Type

- **GET** `/api/v1/Entreprise/Type-Rice/{typeRiceId}`

### Create a New Rice Type

- **POST** `/api/v1/Entreprise/Type-Rice`
- **Request Body:**
  ```json
  {
      "type_rice": "string"
  }
  ```

### Update an Existing Rice Type

- **PUT** `/api/v1/Entreprise/Type-Rice/{typeRiceId}`
- **Request Body:**
  ```json
  {
      "type_rice": "string"
  }
  ```

### Delete a Rice Type

- **DELETE** `/api/v1/Entreprise/Type-Rice/{typeRiceId}`

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/NARIHY/RiceManagement-service
   ```

2. Navigate to the project directory:
   ```bash
   cd RiceManagement-service
   ```

3. Install dependencies:
   ```bash
   composer install
   ```

4. Set up the environment file:
   ```bash
   cp .env.example .env
   ```

5. Generate the application key:
   ```bash
   php artisan key:generate
   ```

6. Run migrations to set up the database:
   ```bash
   php artisan migrate
   ```

7. Start the local development server:
   ```bash
   php artisan serve
   ```



## API Documentation

API documentation is generated using Swagger. To access it, visit:
```
http://<your-local-domain>/api/documentation
```

## Contributing

If you'd like to contribute to the project, please fork the repository and create a pull request.

## License

This project is licensed under the MIT License.

---

Feel free to customize any sections as needed to better match your project's specifics!
