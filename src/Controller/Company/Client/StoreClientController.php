<?php

namespace App\Controller\Company\Client;

use App\Entity\Company\Cin;
use App\Entity\Company\Client;
use App\Entity\GenderManagement;
use App\Entity\User;
use App\Repository\Company\ClientRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Sucre\Service\Human\CINService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Controller for creating a new client in the company context.
 * 
 * This controller handles HTTP requests to create a new client by accepting
 * JSON data, validating the input, and saving the client to the database.
 */
#[AsController]
class StoreClientController
{
    /**
     * The EntityManager is used to interact with the database.
     * 
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;
    private Security $security;

    private ClientRepository $clientRepository;

    private array $cin;

    /**
     * The ValidatorInterface is used to validate the client entity.
     * 
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * Constructor to initialize the EntityManager and ValidatorInterface.
     * 
     * @param EntityManagerInterface $entityManager The entity manager for database interaction.
     * @param ValidatorInterface $validator The validator for validating entities.
     */
    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, Security $security, ClientRepository $clientRepository)
    {
        $this->em = $entityManager;
        $this->validator = $validator;
        $this->security = $security;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Handle the HTTP request to create a new client.
     * 
     * This method processes the incoming JSON data, validates the CIN (Client Identification Number),
     * creates a new Client entity, validates the client entity, and then persists the data to the database.
     * 
     * @param Request $request The HTTP request object containing the client data.
     * 
     * @return JsonResponse JSON response with the status of the operation, including the newly created client data.
     */
    public function __invoke(Request $request): JsonResponse
    {
        // Decode the incoming JSON payload from the request
        $data = json_decode($request->getContent(), true);

        // Validate the incoming data
        if (!isset($data['cin'], $data['name'], $data['lastName'], $data['address'], $data['gender'])) {
            return new JsonResponse(['errors' => 'Missing required fields.'], Response::HTTP_BAD_REQUEST);
        }

        $this->findExistingCin($data['cin']);
        // Validate the CIN (Client Identification Number)
        $validated = $this->validateCin($data['cin']);
        if ($validated->getCode() !== 200) {
            return new JsonResponse(['errors' => $validated::MESSAGE], Response::HTTP_BAD_REQUEST);
        }

        // Create a new Client entity
        $client = new Client();
        $client->setName($data['name']);
        $client->setLastName($data['lastName']);
        $client->setCin($data['cin']);
        // Inject cin to $cin
        $this->cin = $this->validateCin($data['cin'])->checkLocation();
        $client->setCinProvenance($this->createCinForClient($this->cin));
        $client->setAddress($data['address']);

        // Retrieve the Gender entity by ID
        $genderId = (int) filter_var($data['gender'], FILTER_SANITIZE_NUMBER_INT);
        $gender = $this->em->getRepository(GenderManagement::class)->find($genderId);
        if (!$gender) {
            return new JsonResponse(['errors' => 'Gender not found.'], Response::HTTP_BAD_REQUEST);
        }
        $client->setGender($gender);

        $user = $this->security->getUser();  // Get the currently authenticated user
        if (!$user) {
            return new JsonResponse(['errors' => 'User is not authenticated.'], Response::HTTP_UNAUTHORIZED);
        }

        $userIdentifier = $user->getUserIdentifier();  
        $userRepository = $this->em->getRepository(User::class);  

        // Vérification si l'utilisateur est déjà lié à un client
        $userCheckResponse = $this->findExistingUser($userIdentifier);
        if ($userCheckResponse) {
            return $userCheckResponse;  // Retourne l'erreur si l'utilisateur est déjà lié à un client
        }

        // Associate the current user with the client
        $client->setUser($user);

        $client->setCreatedAt($this->date_now());
        $client->setUpdatedAt($this->date_now());

        // Validate the client entity
        $errors = $this->validator->validate($client);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }

        // Persist the client entity to the database
        $this->em->persist($client);
        $this->em->flush();

        // Return a JSON response with the newly created client's details
        return new JsonResponse($client, Response::HTTP_CREATED);
    }

    private function createCinForClient(array $cin): Cin
    {
        $newCin = new Cin();
        $newCin->setLocationRegion($cin['region']);
        $newCin->setLocationProvince($cin['province']);
        $newCin->setLocationZone($cin['zone']);
        $newCin->setPostalCode($cin['postal_code']);
        $newCin->setCountry('Madagascar');

        $this->em->persist($newCin);
        $this->em->flush();
        
        return $newCin;
    }

    /**
     * Get the current date and time as a DateTimeImmutable object.
     * 
     * @return DateTimeImmutable The current date and time.
     */
    private function date_now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }

    /**
     * Validate the CIN (Client Identification Number) using the CINService.
     * 
     * @param string $cin The CIN to be validated.
     * 
     * @return CINService The CIN validation result.
     */
    private function validateCin(string $cin): CINService
    {
        return new CINService($cin);
    }

    private function findExistingCin(string $cin): JsonResponse | null
    {
        $clientLength = $this->clientRepository->findByExistingCin($cin);
        if ($clientLength) {
            return new JsonResponse(['error' => 'This CIN already exists in our application'], Response::HTTP_BAD_REQUEST);
        }
        return null;
    }

    // Correction de la méthode findExistingUser
    private function findExistingUser(string $userIdentifier): JsonResponse | null 
    {
        // Récupérer l'utilisateur par son identifiant (email)
        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $userIdentifier]);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found in database.'], Response::HTTP_BAD_REQUEST);
        }

        // Vérifier si cet utilisateur est déjà associé à un client
        $existingClient = $this->clientRepository->findOneBy(['user' => $user]);
        if ($existingClient) {
            return new JsonResponse(['error' => 'User is already associated with a client.'], Response::HTTP_BAD_REQUEST);
        }

        return null;  // Aucun problème trouvé
    }
}
