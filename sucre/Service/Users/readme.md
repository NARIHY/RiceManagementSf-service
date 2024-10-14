## Service for users

Documentation in two language

## FR

# Documentation du Service UserService

## Vue d'ensemble

La classe `UserService` est responsable de la gestion des opérations liées aux utilisateurs, y compris la création, la mise à jour et la récupération des informations utilisateur dans l'application. Ce service abstrait la logique métier liée à la gestion des utilisateurs, permettant ainsi une séparation claire des préoccupations et une meilleure maintenabilité.

## Namespace
```php
namespace Sucre\Service\Users;
```

## Méthodes

### 1. listAllUsers
```php
public function listAllUsers(): Collection
```
**Description**: Récupère tous les utilisateurs de la base de données par date de création décroissante.

**Retourne**: `Collection` - Une collection de tous les utilisateurs.

### 2. listAllUsersWithPagination
```php
public function listAllUsersWithPagination(int $perPage): LengthAwarePaginator
```
**Description**: Récupère tous les utilisateurs avec un support de pagination.

**Paramètres**:
- `int $perPage`: Le nombre d'utilisateurs par page.

**Retourne**: `LengthAwarePaginator` - Une liste paginée d'utilisateurs.

### 3. findUserByName
```php
public function findUserByName(string $name): ?User
```
**Description**: Trouve un utilisateur par son nom.

**Paramètres**:
- `string $name`: Le nom de l'utilisateur à trouver.

**Retourne**: `User|null` - L'objet utilisateur si trouvé, sinon null.

### 4. findUserByEmail
```php
public function findUserByEmail(string $email): ?User
```
**Description**: Trouve un utilisateur par son adresse e-mail.

**Paramètres**:
- `string $email`: L'e-mail de l'utilisateur à trouver.

**Retourne**: `User|null` - L'objet utilisateur si trouvé, sinon null.

### 5. getUserConnected
```php
public function getUserConnected(): ?User
```
**Description**: Récupère l'utilisateur actuellement authentifié.

**Retourne**: `User|null` - L'objet utilisateur authentifié si connecté, sinon null.

### 6. createUser
```php
public function createUser(UserStoreRequest $request): JsonResponse
```
**Description**: Crée un nouvel utilisateur avec les données fournies.

**Paramètres**:
- `UserStoreRequest $request`: L'objet de requête contenant les données utilisateur validées.

**Retourne**: `JsonResponse` - Une réponse JSON indiquant le succès ou l'échec de l'opération.

**Lève**: `HttpResponseException` si l'e-mail existe déjà.

### 7. updateUserConnected
```php
public function updateUserConnected(UserUpdateRequest $request): bool
```
**Description**: Met à jour les informations de l'utilisateur actuellement authentifié.

**Paramètres**:
- `UserUpdateRequest $request`: L'objet de requête contenant les données utilisateur validées.

**Retourne**: `bool` - Vrai si la mise à jour a réussi.

**Lève**: `ModelNotFoundException` si l'utilisateur n'est pas authentifié.

### 8. updateUserByAdmin
```php
public function updateUserByAdmin(UserUpdateRequest $request, string $userId): JsonResponse
```
**Description**: Permet à un administrateur de mettre à jour les informations d'un utilisateur spécifié.

**Paramètres**:
- `UserUpdateRequest $request`: L'objet de requête contenant les données utilisateur validées.
- `string $userId`: L'ID de l'utilisateur à mettre à jour.

**Retourne**: `JsonResponse` - Une réponse JSON indiquant le succès ou l'échec de l'opération.

**Lève**: `ModelNotFoundException` si l'utilisateur n'est pas trouvé.

### 9. verifyEmailAddress
```php
private function verifyEmailAddress(string $email): ?JsonResponse
```
**Description**: Vérifie si l'adresse e-mail fournie existe déjà dans la base de données.

**Paramètres**:
- `string $email`: L'adresse e-mail à vérifier.

**Retourne**: `JsonResponse|null` - Une réponse de conflit si l'e-mail existe, sinon null.

### 10. hashPassword
```php
private function hashPassword(string $password): string
```
**Description**: Hache le mot de passe fourni à l'aide d'un algorithme de hachage sécurisé.

**Paramètres**:
- `string $password`: Le mot de passe à hacher.

**Retourne**: `string` - Le mot de passe haché.

## Utilisation
Pour utiliser le `UserService`, instanciez la classe et appelez les méthodes souhaitées pour gérer les données utilisateur. Assurez-vous de gérer les exceptions qui peuvent être levées lors de la création ou des mises à jour des utilisateurs.

## Exemple
```php
$userService = new UserService();
$response = $userService->createUser($request);
```

## Tests
Le `UserService` comprend divers tests unitaires pour garantir le bon fonctionnement de ses méthodes. Les tests couvrent la création d'utilisateur réussie, les mises à jour d'utilisateur, les scénarios d'erreur pour les e-mails existants, et plus encore.


## English

# UserService Documentation

## Overview

The `UserService` class is responsible for managing user-related operations, including creating, updating, and retrieving user information within the application. This service abstracts the business logic related to user management, allowing for a clean separation of concerns and easier maintainability.

## Namespace
```php
namespace Sucre\Service\Users;
```

## Methods

### 1. listAllUsers
```php
public function listAllUsers(): Collection
```
**Description**: Retrieves all users from the database in descending order of creation date.

**Returns**: `Collection` - A collection of all users.

### 2. listAllUsersWithPagination
```php
public function listAllUsersWithPagination(int $perPage): LengthAwarePaginator
```
**Description**: Retrieves all users with pagination support.

**Parameters**:
- `int $perPage`: The number of users per page.

**Returns**: `LengthAwarePaginator` - A paginated list of users.

### 3. findUserByName
```php
public function findUserByName(string $name): ?User
```
**Description**: Finds a user by their name.

**Parameters**:
- `string $name`: The name of the user to find.

**Returns**: `User|null` - The user object if found, null otherwise.

### 4. findUserByEmail
```php
public function findUserByEmail(string $email): ?User
```
**Description**: Finds a user by their email address.

**Parameters**:
- `string $email`: The email of the user to find.

**Returns**: `User|null` - The user object if found, null otherwise.

### 5. getUserConnected
```php
public function getUserConnected(): ?User
```
**Description**: Retrieves the currently authenticated user.

**Returns**: `User|null` - The authenticated user object if logged in, null otherwise.

### 6. createUser
```php
public function createUser(UserStoreRequest $request): JsonResponse
```
**Description**: Creates a new user with the provided data.

**Parameters**:
- `UserStoreRequest $request`: The request object containing validated user data.

**Returns**: `JsonResponse` - A JSON response indicating the success or failure of the operation.

**Throws**: `HttpResponseException` if the email already exists.

### 7. updateUserConnected
```php
public function updateUserConnected(UserUpdateRequest $request): bool
```
**Description**: Updates the information of the currently authenticated user.

**Parameters**:
- `UserUpdateRequest $request`: The request object containing validated user data.

**Returns**: `bool` - True if the update was successful.

**Throws**: `ModelNotFoundException` if the user is not authenticated.

### 8. updateUserByAdmin
```php
public function updateUserByAdmin(UserUpdateRequest $request, string $userId): JsonResponse
```
**Description**: Allows an admin to update a specified user's information.

**Parameters**:
- `UserUpdateRequest $request`: The request object containing validated user data.
- `string $userId`: The ID of the user to update.

**Returns**: `JsonResponse` - A JSON response indicating the success or failure of the operation.

**Throws**: `ModelNotFoundException` if the user is not found.

### 9. verifyEmailAddress
```php
private function verifyEmailAddress(string $email): ?JsonResponse
```
**Description**: Verifies if the provided email address already exists in the database.

**Parameters**:
- `string $email`: The email address to verify.

**Returns**: `JsonResponse|null` - A conflict response if the email exists, null otherwise.

### 10. hashPassword
```php
private function hashPassword(string $password): string
```
**Description**: Hashes the provided password using a secure hashing algorithm.

**Parameters**:
- `string $password`: The password to hash.

**Returns**: `string` - The hashed password.

## Usage
To use the `UserService`, instantiate the class and call the desired methods to manage user data. Ensure to handle any exceptions that may be thrown during user creation or updates.

## Example
```php
$userService = new UserService();
$response = $userService->createUser($request);
```

## Testing
The `UserService` includes various unit tests to ensure the functionality of its methods. Tests cover successful user creation, user updates, error scenarios for existing emails, and more.

