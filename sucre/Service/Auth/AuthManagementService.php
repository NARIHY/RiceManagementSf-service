<?php

namespace Sucre\Service\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\PasswordForgottenRequest;
use App\Notifications\Auth\PasswordForgotenNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class AuthManagementService
 *
 * This class handles user authentication, password resets, and logout functionality.
 * It provides methods for logging in users, sending password reset links,
 * and logging out authenticated users. Each method includes validation and appropriate responses.
 *
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class AuthManagementService
{
    /**
     * Authenticates a user based on provided login credentials.
     *
     * @param LoginRequest $request The incoming request containing login credentials.
     * @return JsonResponse A JSON response indicating the authentication status and token if successful.
     */
    public function authentificate_user(LoginRequest $request): JsonResponse
    {
        // Retrieve the email and password from the request
        $credentials = $request->only('email', 'password');

        // Check if a user exists with the provided email
        $user = User::where('email', $credentials['email'])->first();

        // Verify the password against the stored password hash
        if ($this->verifyPassword($credentials['password'], $user->password) !== true) {
            return response()->json(['message' => 'Invalid credentials'], Response::HTTP_BAD_REQUEST);
        }

        // Log the user in and generate an authentication token
        Auth::login($user);
        $token = $user->createToken($user->name . '|' . $user->email)->plainTextToken;

        // Return a success response with the authentication token
        return response()->json(['message' => 'Connected', 'token' => $token], Response::HTTP_OK);
    }

    /**
     * Handles the password reset request for users.
     *
     * @param PasswordForgottenRequest $request The incoming request containing the email for password reset.
     * @return JsonResponse A JSON response indicating the status of the password reset link sending.
     */
    public function password_forgotten_user(PasswordForgottenRequest $request): JsonResponse
    {
        $userEmail = $request->validated('email');
        $user = User::where('email', $userEmail)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found.'], Response::HTTP_NOT_FOUND);
        }

        // Generate a new random password
        $newPassword = \Str::random(10); // Generates a random password of 10 characters

        // Save the new password (remember to hash it)
        $user->password = $newPassword;
        $user->save();

        $data = [
            'name' => $user->name,
            'password' => $newPassword
        ];

        // Send the new password to the user's email
        $user->notify(new PasswordForgotenNotification($data));

        return response()->json(['message' => 'A new password has been sent to your email.'], Response::HTTP_OK);
    }

    /**
     * Logs out the authenticated user.
     *
     * @param Request $request The incoming request (not used in this method).
     * @return JsonResponse A JSON response indicating the logout status.
     */
    public function logout_user_user(Request $request): JsonResponse
    {
        // Check if the user is currently authenticated
        if ($request->user()) {
            // Revoke the user's current access token
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logged out successfully.'], Response::HTTP_OK);
        }

        return response()->json(['message' => 'Unauthorized.'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Verifies the input password against the stored password hash.
     *
     * @param string $inputPassword The password provided by the user during login.
     * @param string $storedHash The stored hash of the user's password.
     * @return bool Returns true if the password is valid, otherwise false.
     */
    private function verifyPassword(string $inputPassword, string $storedHash): bool
    {
        // Split the stored hash to get the salt and the hashed password
        list($salt, $hash) = explode(':', $storedHash);

        // Hash the input password with the stored salt
        $inputHash = hash('sha256', $salt . $inputPassword);

        // Use hash_equals to securely compare the two hashes
        return hash_equals($inputHash, $hash); // Protects against timing attacks
    }
}
