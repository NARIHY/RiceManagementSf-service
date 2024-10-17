<?php

namespace App\Controller\Company\Client;

use App\Entity\Company\Client;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Sucre\Service\Human\CINService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
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
    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->em = $entityManager;
        $this->validator = $validator;
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

        // Validate the CIN (Client Identification Number)
        $validated = $this->validateCin($data['cin']);
        if ($validated->getCode() !== 200) {
            // If CIN validation fails, return a 400 Bad Request response with error message
            return new JsonResponse(['errors' => $validated::MESSAGE], Response::HTTP_BAD_REQUEST);
        }

        // Create a new Client entity
        $client = new Client();
        $client->setName($data['name']);
        $client->setLastName($data['lastName']);
        $client->setCin($data['cin']);
        $client->setAddress($data['address']);
        $client->setCreatedAt($this->date_now());
        $client->setUpdatedAt($this->date_now());

        // Validate the client entity (e.g., check for required fields and constraints)
        $errors = $this->validator->validate($client);
        if (count($errors) > 0) {
            // If there are validation errors, return a 400 Bad Request response
            return new JsonResponse(['errors' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }

        // Persist the client entity to the database and flush the changes
        $this->em->persist($client);
        $this->em->flush();

        // Return a JSON response with the newly created client's details and a 201 Created status
        return new JsonResponse([
            'id' => $client->getId(),
            'name' => $client->getName(),
            'lastName' => $client->getLastName(),
            'address' => $client->getAddress(),
            'cin' => $client->getCin()
        ], Response::HTTP_CREATED);
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
}
