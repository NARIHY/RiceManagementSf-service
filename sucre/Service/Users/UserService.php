<?php

namespace Sucre\Service\Users;

use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Http\Resources\Users\UserManagementResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package Sucre\Service\Users
 *
 *
 * Service class for managing user operations such as creating, updating, and retrieving users.
 *
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class UserService
{
    /**
    * {
    * "name": "John Doe",
    * "email": "john.doe@example.com",
    * "password": "securepassword",
    * "password_confirmation": "securepassword",
    * "gender_management_id": 1
    * }
     */
    /**
     * Retrieve all users.
     *
     * @return Collection
     */
    public function listAllUsers(): Collection
    {
        return User::orderBy("created_at", "desc")->get();
    }

    /**
     * Retrieve all users with pagination.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function listAllUsersWithPagination(int $perPage): LengthAwarePaginator
    {
        return User::orderBy("created_at", "desc")->paginate($perPage);
    }

    /**
     * Find a user by their name.
     *
     * @param string $name
     * @return User|null
     */
    public function findUserByName(string $name): ?User
    {
        return User::where("name", $name)->first();
    }

    /**
     * Find a user by their email.
     *
     * @param string $email
     * @return User|null
     */
    public function findUserByEmail(string $email): ?User
    {
        return User::where("email", $email)->first();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return User|null
     */
    public function getUserConnected(): ?User
    {
        return Auth::user();
    }

    /**
     * Create a new user in the system.
     *
     * This method validates the incoming request data for user creation, checks that the
     * provided email address does not already exist in the database, and creates a new
     * user record with the validated data. The user's password is hashed before storing it
     * to ensure security.
     *
     * Expected fields in the request:
     * - name: The full name of the user.
     * - email: The unique email address of the user.
     * - password: The user's password (will be hashed).
     * - gender_management_id: An identifier for the user's gender.
     *
     * @param \App\Http\Requests\Users\UserStoreRequest $request The validated request containing user data.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response indicating the success of the user creation,
     *                     including the created user object and a generated authentication token.
     * @throws HttpResponseException If the email already exists in the database, a conflict response will be returned.
     *
     * Testing:
     * This method has been tested using unit tests that mock the UserStoreRequest to simulate
     * various scenarios, including successful user creation and email conflict cases.
     *
     * Risks:
     * - If the email address provided in the request already exists, the method will throw an
     *   error, leading to an unsuccessful user creation.
     * - Improper handling of exceptions could result in sensitive information exposure.
     */
    public function createUser(UserStoreRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $this->verifyEmailAddress($validatedData['email']);

        $data = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'gender_management_id' => $validatedData['gender_management_id'],
            'type_compte_management_id' => 1
        ];

        $user = User::create($data);
        $token = $user->createToken($validatedData['name'] . '|' . $validatedData['email']);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user, // Ensure this is structured correctly
            'token' => $token->plainTextToken // Ensure this is a string
        ], Response::HTTP_CREATED);
    }



    /**
     * Update the authenticated user's information.
     *
     * This method allows the authenticated user to update their profile information, including their name,
     * email, and password. It checks if the email address has changed and verifies its uniqueness in the database.
     * The password is hashed before being stored.
     *
     * Actions:
     * - Retrieve the currently authenticated user.
     * - Validate the incoming request data.
     * - Check if the email has changed and verify its uniqueness.
     * - Hash the new password if provided.
     * - Update the user's information in the database.
     *
     * @param UserUpdateRequest $request The request containing the validated user data for the update.
     * @return bool Returns true if the update was successful.
     * @throws ModelNotFoundException Thrown if no user is authenticated during the update attempt.
     * @throws JsonResponse Thrown if the email already exists in the database (via verifyEmailAddress method).
     */
    public function updateUserConnected(UserUpdateRequest $request): bool
    {
        // Get the currently authenticated user
        $user = Auth::user();
        if (!$user) {
            throw new ModelNotFoundException('User not authenticated');
        }

        // Validate the incoming request data
        $data = $request->validated();

        // Verify if the email exists only if it's changed
        if (!empty($data['email']) && $data['email'] !== $user->email) {
            $this->verifyEmailAddress($data['email']);
        }

        // Hash the password if provided
        if (!empty($data['password'])) {
            $data['password'] = $data['password'];
        }

        // Update the user's information
        $user->update($data);

        return true;
    }



    /**
     * Update a user's information by an admin.
     *
     * This method allows an admin to update the information of a specified user.
     * It validates the input data, checks if the user exists, and updates the user
     * details in the database. The method handles password hashing and email
     * verification to ensure data integrity.
     *
     * Actions:
     * - Retrieve the user based on the provided user ID.
     * - If the user does not exist, respond with a 404 Not Found status.
     * - Validate the input data from the UserUpdateRequest.
     * - If a new password is provided, verify that the email is unique and hash the password.
     * - Update the user's information in the database.
     * - Respond with a success message if the update is successful.
     *
     * @param UserUpdateRequest $request The request containing validated data for the user update.
     * @param string $userId The ID of the user to be updated.
     * @return JsonResponse A JSON response indicating success or failure.
     * @throws ModelNotFoundException Thrown if the user ID does not correspond to any existing user.
     */
    public function updateUserByAdmin(UserUpdateRequest $request, string $userId): JsonResponse
    {
        // Retrieve the user based on the provided user ID
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'Undefined user'], Response::HTTP_NOT_FOUND);
        }

        // Validate the input data from the UserUpdateRequest
        $data = $request->validated();

        // If a new password is provided, verify that the email is unique
        if (!empty($data['password'])) {
            $this->verifyEmailAddress($data['email']);
            $data['password'] = $data['password'];
        }

        // Update the user's information in the database
        $user->update($data);

        // Respond with a success message
        return response()->json(['message' => 'Updated successfully'], Response::HTTP_OK);
    }







    /**
     * Verify if the email address already exists in the database.
     *
     * This method checks if a user with the given email address already exists.
     * If the email exists, it throws an HttpResponseException with a conflict message.
     *
     * @param string $email The email address to check for existence.
     * @throws HttpResponseException If the email already exists in the database.
     */
    private function verifyEmailAddress(string $email): void
    {
        if (User::where('email', $email)->exists()) {
            throw new HttpResponseException(response()->json(['message' => 'This email already exists in the database.'], Response::HTTP_CONFLICT));
        }
    }
}
