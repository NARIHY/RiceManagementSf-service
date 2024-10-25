<?php 

namespace App\Controller\Company\Stock;

use App\Entity\Stock\Bag;
use App\Entity\Stock\Stock;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class StoreBagController 
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }
    
    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data['quantity'])) {
            return new JsonResponse(['error' => 'Quantity is required.'], Response::HTTP_BAD_REQUEST);
        }
        $bag = new Bag();
        $bag->setQuantity($data['quantity']);
        $stock = $this->createStockForBag($bag);
        $bag->addStock($stock);
        $this->entityManager->persist($bag);
        $this->entityManager->flush();
        return new JsonResponse(['message' => 'bag added succefully'], Response::HTTP_CREATED);
    }

    private function createStockForBag(Bag $bag): Stock
    {
        $stock = new Stock();
        $stock->setAivalableQuantity($bag->getQuantity()); // Corrected method name

        // Persist the Stock entity
        $this->entityManager->persist($stock);

        return $stock;
    }
}
