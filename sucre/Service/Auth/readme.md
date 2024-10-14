```markdown
# AuthManagementService

The `AuthManagementService` class provides functionality for user authentication, password resets, and user logout in a Laravel application. This service handles the login process, allows users to request password resets, and facilitates secure logout operations.

## Features

- **User Authentication**: Authenticates users based on email and password.
- **Password Reset**: Allows users to request a password reset and receive a new password via email.
- **Logout Functionality**: Enables users to log out and revoke their authentication tokens.

## Requirements

- PHP 8.1 or higher
- Laravel 11.x or higher
- Composer dependencies as defined in the Laravel application

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

4. Set up your environment file:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

## Usage

### 1. User Authentication

To authenticate a user, send a `POST` request to `/api/auth/login` with the following parameters:

- `email`: User's email address
- `password`: User's password

**Example Request:**

```json
{
    "email": "user@example.com",
    "password": "userpassword"
}
```

**Response:**

- On success:
  ```json
  {
      "message": "Connected",
      "token": "<auth-token>"
  }
  ```

- On failure:
  ```json
  {
      "message": "Invalid credentials"
  }
  ```

### 2. Password Reset

To request a password reset, send a `POST` request to `/api/auth/password-forgotten` with the following parameter:

- `email`: User's email address

**Example Request:**

```json
{
    "email": "user@example.com"
}
```

**Response:**

- On success:
  ```json
  {
      "message": "A new password has been sent to your email."
  }
  ```

- On failure (user not found):
  ```json
  {
      "message": "User not found."
  }
  ```

### 3. Logout

To log out the authenticated user, send a `POST` request to `/api/auth/logout`. Ensure that the request includes the user's authentication token in the header.

**Example Request:**

```http
POST /api/auth/logout
Authorization: Bearer <auth-token>
```

**Response:**

- On success:
  ```json
  {
      "message": "Logged out successfully."
  }
  ```

- On failure (unauthorized):
  ```json
  {
      "message": "Unauthorized."
  }
  ```

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Author

**RANDRIANARISOA**  
Email: [maheninarandrianarisoa@gmail.com](mailto:maheninarandrianarisoa@gmail.com)
```

Feel free to customize any part of this README to better fit your project or personal style!
