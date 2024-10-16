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

#[AsController]
class StoreClientController
{
    private EntityManagerInterface $em;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->em = $entityManager;
        $this->validator = $validator;
    }
    public function __invoke(Request $request): JsonResponse
    {
        
        $data = json_decode($request->getContent(), true);
        $this->validateCin($data['cin']);
        $client = new Client();
        $client->setName($data['name']);
        $client->setLastName($data['lastName']);
        $client->setCin($data['cin']);
        $client->setAddress($data['address']);
        $client->setCreatedAt($this->date_now());
        $client->setUpdatedAt($this->date_now());

        $errors = $this->validator->validate($client);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }

        
        $this->em->persist($client);
        $this->em->flush();

        return new JsonResponse([
            'id' => $client->getId(),
            'name' => $client->getName(),
            'lastName' => $client->getLastName(),
            'address' => $client->getAddress(),
            'cin' => $client->getCin()

        ], Response::HTTP_CREATED);
    }

    private function date_now(): DateTimeImmutable {
        return new DateTimeImmutable();
    }

    private function validateCin(string $cin): CINService {
        return $cin_service = new CINService($cin);
        
    }
}