<?php
namespace App\Controller\Client;

use App\Entity\Client\Contact;
use Sucre\Service\Phone\PhoneNumberService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sucre\Service\Email\EmailService;

#[AsController]
class ContactPostController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private PhoneNumberService $phoneNumberService;

    private EmailService $emailService;

    // Injection de l'EntityManagerInterface dans le constructeur
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;       
    }


    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON data'], 400);
        }
        if(!empty($data['phoneNumber'])){
            $this->phoneNumberService = new PhoneNumberService($data['phoneNumber']);            
        }
        if(!$this->phoneNumberService->isValid()) {
            return new JsonResponse(['error' => 'The phone number must Madagascar Typically phone number in Madagascar.'], 400);
        }      
        if(!empty($data['email'])) {
            $this->emailService = new EmailService($data['email']);
        }       
        $contact = new Contact();
        $contact->setName($data['name'] ?? null);
        $contact->setLastName($data['lastName'] ?? null);
        $contact->setEmail($data['email'] ?? null);
        $contact->setPhoneNumber($this->format_phone_number() ?? null);
        $contact->setCreationDate(new \DateTimeImmutable());
        try {
            $this->entityManager->persist($contact);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error saving contact: ' . $e->getMessage()], 400);
        }
        return $this->json($contact, 201, [], [
            'groups' => ['contact:collection:get', 'contact:collection:post'] 
        ]);
    }

    private function format_phone_number(): string
    {
        return $this->phoneNumberService->format();
    }
}

