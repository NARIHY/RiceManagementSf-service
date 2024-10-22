<?php 

namespace App\Controller\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController {

    #[Route(path: '/api/login', name: 'api_login' , methods:['POST'])]
    public function login() {
        $user = $this->getUser();
        return $this->json([
            'user_identifier' => $user->getUserIdentifier(),
            'role' => $user->getRoles()
        ]);
    }

    #[Route(path: '/api/register', name: 'api_register', methods: ['POST'])]
    public function register(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $passwordHasher, ValidatorInterface $validator): JsonResponse {
        $data = $this->getRequestData($request);

        if ($data === null || !$this->isValidInput($data)) {
            return $this->createErrorResponse('Email and password are required.', 400);
        }

        $user = $this->createUser($data['email'], $data['password'], $passwordHasher);

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return $this->createErrorResponse((string) $errors, 400);
        }

        return $this->handleUserRegistration($entityManager, $user);
    }

    private function getRequestData(Request $request): ?array {
        return json_decode($request->getContent(), true);
    }

    private function isValidInput(array $data): bool {
        return isset($data['email'], $data['password']) && !empty($data['email']) && !empty($data['password']);
    }

    private function createUser(string $email, string $password, UserPasswordHasherInterface $passwordHasher): User {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($passwordHasher->hashPassword($user, $password));
        $user->setRoles(["ROLE_CLIENT"]);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());
        return $user;
    }

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

    private function createErrorResponse(string $message, int $statusCode): JsonResponse {
        return new JsonResponse(['error' => $message], $statusCode);
    }

}