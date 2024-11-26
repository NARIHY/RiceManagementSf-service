<?php
namespace App\Controller\Client;

use App\Entity\Client\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

#[AsController]
class ContactPostController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    // Injection de l'EntityManagerInterface dans le constructeur
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function __invoke(Request $request): JsonResponse
    {
        // Récupérer les données envoyées dans le corps de la requête
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON data'], 400);
        }

        // Créer un nouvel objet Contact avec les données reçues
        $contact = new Contact();
        $contact->setName($data['name'] ?? null);
        $contact->setLastName($data['lastName'] ?? null);
        $contact->setEmail($data['email'] ?? null);
        $contact->setPhoneNumber($data['phoneNumber'] ?? null);
        $contact->setCreationDate(new \DateTime()); // Définir la date de création

        // Utiliser l'EntityManager pour persister l'entité
        try {
            $this->entityManager->persist($contact); // Marque l'entité pour persistance
            $this->entityManager->flush(); // Sauvegarde l'entité dans la base de données
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error saving contact: ' . $e->getMessage()], 500);
        }

        // Retourner une réponse JSON avec le contact créé
        return $this->json($contact, 201, [], [
            'groups' => ['contact:collection:get', 'contact:collection:post'] // Utilisation des groupes de sérialisation
        ]);
    }
}

