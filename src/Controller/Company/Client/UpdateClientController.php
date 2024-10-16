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

#[AsController]
class UpdateClientController 
{
    private EntityManagerInterface $em;

    private ValidatorInterface $validators;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator) {
        $this->em = $em;
        $this->validators = $validator;
    }


    public function __invoke(Request $request, int $id): JsonResponse {
        $client = $this->em->getRepository(Client::class)->find($id);
        if (!$client) {
            return new JsonResponse(['error' => 'Client not found'], Response::HTTP_NOT_FOUND);
        }
    
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }
    
        $this->updateClient($client, $data);
        
        $errors = $this->validators->validate($client);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }
    
        $this->em->flush();
        return new JsonResponse(['message' => 'Client updated successfully'], Response::HTTP_OK);
    }
    
    private function updateClient(Client $client, array $data): void {
        if (isset($data['address'])) {
            $client->setAddress($data['address']);
        }
        $client->setUpdatedAt($this->date_now());
    }

    private function date_now(): DateTimeImmutable {
        return new DateTimeImmutable();
    }
}