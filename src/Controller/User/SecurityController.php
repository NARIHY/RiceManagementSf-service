<?php 

namespace App\Controller\User;

use App\Entity\TokenBlacklist;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityController extends AbstractController {

    
    /**
     * Handles user login.
     * 
     * @return JsonResponse
     */
    #[Route(path: '/api/login', name: 'api_login', methods: ['POST'])]
    public function login() {
        $user = $this->getUser();
        return $this->json([
            'user_identifier' => $user->getUserIdentifier(),
            'role' => $user->getRoles()
        ]);
    }
    
    /**
     * Handles user registration.
     *
     * @param EntityManagerInterface $entityManager The entity manager.
     * @param Request $request The incoming request.
     * @param UserPasswordHasherInterface $passwordHasher The password hasher.
     * @param ValidatorInterface $validator The validator service.
     * 
     * @return JsonResponse
     */
    #[Route(path: '/api/register', name: 'api_register', methods: ['POST'])]
    public function register(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $passwordHasher, ValidatorInterface $validator): JsonResponse {
        $data = $this->getRequestData($request);

        if ($data === null || !$this->isValidInput($data)) {
            return $this->createErrorResponse('Email and password are required.', 400);
        }

        $user = $this->createUser($data['email'], $data['password'], $passwordHasher);

        // Validate the user entity.
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return $this->createErrorResponse((string) $errors, 400);
        }

        return $this->handleUserRegistration($entityManager, $user);
    }

    /**
     * Handles user logout by blacklisting the provided token.
     *
     * @param Request $request The incoming request.
     * @param EntityManagerInterface $entityManager The entity manager.
     * 
     * @return Response
     */
    #[Route('/api/logout', name: 'app_logout', methods: ['POST'])]
    public function logout(Request $request, EntityManagerInterface $entityManager): Response {
        // Retrieve the token from headers.
        $token = $request->headers->get('Authorization');

        if ($token) {
            $blacklistedToken = new TokenBlacklist($token);
            $entityManager->persist($blacklistedToken);
            $entityManager->flush();

            return new Response('Déconnexion réussie.', Response::HTTP_OK);
        }

        return new Response('Aucun token trouvé.', Response::HTTP_BAD_REQUEST);
    }

    /**
     * Checks if the user is connected based on the provided token.
     *
     * @param Request $request The incoming request.
     * @param EntityManagerInterface $entityManager The entity manager.
     * 
     * @return Response
     */
    #[Route('/api/check-connection', name: 'app_check_connection',methods:['GET'])]
    public function checkConnection(Request $request, EntityManagerInterface $entityManager): Response {
        // Retrieve the token from headers.
        $token = $request->headers->get('Authorization');

        if (!$token) {
            return new JsonResponse('Non connecté.', Response::HTTP_UNAUTHORIZED);
        }

        // Check if the token is blacklisted.
        $blacklistedToken = $entityManager->getRepository(TokenBlacklist::class)->findOneBy(['token' => $token]);

        if ($blacklistedToken) {
            return new JsonResponse('Utilisateur non connecter. Non connecté.', Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse('Utilisateur connecté.', Response::HTTP_OK);
    }

    /**
     * Extracts and decodes JSON data from the request.
     *
     * @param Request $request The incoming request.
     * 
     * @return array|null
     */
    private function getRequestData(Request $request): ?array {
        return json_decode($request->getContent(), true);
    }

    /**
     * Validates the input data for registration.
     *
     * @param array $data The input data.
     * 
     * @return bool
     */
    private function isValidInput(array $data): bool {
        return isset($data['email'], $data['password']) && !empty($data['email']) && !empty($data['password']);
    }

    /**
     * Creates a new user entity.
     *
     * @param string $email The user's email.
     * @param string $password The user's password.
     * @param UserPasswordHasherInterface $passwordHasher The password hasher.
     * 
     * @return User
     */
    private function createUser(string $email, string $password, UserPasswordHasherInterface $passwordHasher): User {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($passwordHasher->hashPassword($user, $password));
        $user->setRoles(["ROLE_CLIENT"]);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());
        
        return $user;
    }

    /**
     * Handles the user registration process.
     *
     * @param EntityManagerInterface $entityManager The entity manager.
     * @param User $user The user entity to register.
     * 
     * @return JsonResponse
     */
    private function handleUserRegistration(EntityManagerInterface $entityManager, User $user): JsonResponse {
        try {
            $entityManager->beginTransaction();
            $entityManager->persist($user);
            $entityManager->flush();
            $entityManager->commit();
        } catch (\Exception $e) {
            $entityManager->rollback();
            return $this->createErrorResponse('Failed to register user', 400);
        }

        return new JsonResponse(['message' => 'User registered successfully', 'user' => ['username' => $user->getUserIdentifier()]], 201);
    }

    /**
     * Creates an error response with a given message and status code.
     *
     * @param string $message The error message.
     * @param int $statusCode The HTTP status code.
     * 
     * @return JsonResponse
     */
    private function createErrorResponse(string $message, int $statusCode): JsonResponse {
        return new JsonResponse(['error' => $message], $statusCode);
    }

}
