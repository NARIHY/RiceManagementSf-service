<?php 
namespace App\Controller\Company\Client;

use App\Entity\Company\Client;
use Doctrine\ORM\EntityManagerInterface;
use Sucre\Service\Human\CINService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetOneClientController 
{
    private EntityManagerInterface $em;
    /**
     * Constructor to initialize the EntityManager and ValidatorInterface.
     * 
     * @param EntityManagerInterface $em The entity manager for database interaction.
     */
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    public function __invoke(int $id)
    {
        $client = $this->em->getRepository(Client::class)->find($id);
        if (!$client) {
            return new JsonResponse(['error' => 'Client not found'], Response::HTTP_NOT_FOUND);
        }
        $cin_client = new CINService($client->getCin());
        return new JsonResponse([
            'name' => $client->getName(),
            'lastName' => $client->getLastName(),
            'cin' => $client->getCin(),
            'address' => $client->getAddress(),
            'cin_provenance' => $cin_client->checkLocation(),
            'createdAt' => $client->getCreatedAt(),
            'updatedAt' => $client->getUpdatedAt()
        ], Response::HTTP_OK);
    }
}