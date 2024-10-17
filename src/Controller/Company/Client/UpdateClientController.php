<?php

namespace App\Controller\Company\Client;

use App\Entity\Company\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for updating a client in the company context.
 * 
 * This controller handles HTTP requests to update a client's information.
 * It expects a JSON payload and validates the client entity after the update.
 */
#[AsController]
class UpdateClientController 
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
    private ValidatorInterface $validators;

    /**
     * Constructor to initialize the EntityManager and ValidatorInterface.
     * 
     * @param EntityManagerInterface $em The entity manager for database interaction.
     * @param ValidatorInterface $validator The validator for validating entities.
     */
    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator) {
        $this->em = $em;
        $this->validators = $validator;
    }

    /**
     * Update the client with the provided ID using the data from the request.
     * 
     * @param Request $request The HTTP request object containing the client update data.
     * @param int $id The ID of the client to be updated.
     * 
     * @return JsonResponse JSON response with the status of the operation.
     */
    public function __invoke(Request $request, int $id): JsonResponse {
        // Retrieve the client entity from the database
        $client = $this->em->getRepository(Client::class)->find($id);
        
        // If the client doesn't exist, return a 404 Not Found response
        if (!$client) {
            return new JsonResponse(['error' => 'Client not found'], Response::HTTP_NOT_FOUND);
        }

        // Decode the JSON payload from the request
        $data = json_decode($request->getContent(), true);
        
        // If the JSON is invalid, return a 400 Bad Request response
        if (json_last_error() !== JSON_ERROR_NONE) {
            return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }
        
        // Update the client with the new data
        $this->updateClient($client, $data);
        
        // Validate the updated client entity
        $errors = $this->validators->validate($client);
        if (count($errors) > 0) {
            // If there are validation errors, return them in the response
            return new JsonResponse(['errors' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }

        // Persist the changes and flush to the database
        $this->em->flush();
        
        // Return a success response
        return new JsonResponse(['message' => 'Client updated successfully'], Response::HTTP_OK);
    }

    /**
     * Update the client entity with the provided data.
     * 
     * This method updates the client's address if provided, and updates the
     * client's "updatedAt" timestamp to the current date and time.
     * 
     * @param Client $client The client entity to be updated.
     * @param array $data The data to update the client with.
     */
    private function updateClient(Client $client, array $data): void {
        // Check if the address is provided in the request data
        if (isset($data['address'])) {
            $client->setAddress($data['address']);
        }
        
        // Update the "updatedAt" timestamp to the current date and time
        $client->setUpdatedAt($this->date_now());
    }

    /**
     * Get the current date and time as a DateTimeImmutable object.
     * 
     * @return DateTimeImmutable The current date and time.
     */
    private function date_now(): DateTimeImmutable {
        return new DateTimeImmutable();
    }
}
