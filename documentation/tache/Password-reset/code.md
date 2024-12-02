Pour implémenter une fonctionnalité de réinitialisation de mot de passe dans une API utilisant API Platform et Symfony, vous devez suivre plusieurs étapes. Voici un guide détaillé pour accomplir cela :

### Étape 1 : Créer une méthode dans le contrôleur de l'utilisateur pour générer le token et envoyer l'email.

Dans cette étape, nous allons créer une méthode dans un contrôleur qui recevra l'adresse e-mail de l'utilisateur, générera un token de réinitialisation, puis enverra un email à l'utilisateur avec un lien contenant ce token. Le token expirera après 5 minutes.

#### 1.1 Créer un contrôleur pour la réinitialisation de mot de passe.

Créez un fichier `PasswordResetController.php` dans le répertoire `src/Controller/`.

```php
// src/Controller/PasswordResetController.php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\PasswordResetService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class PasswordResetController extends AbstractController
{
    private $mailer;
    private $passwordResetService;
    private $userRepository;
    private $entityManager;

    public function __construct(
        MailerInterface $mailer,
        PasswordResetService $passwordResetService,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->mailer = $mailer;
        $this->passwordResetService = $passwordResetService;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/api/password-reset", name="password_reset_request", methods={"POST"})
     */
    public function requestPasswordReset(Request $request): JsonResponse
    {
        $email = $request->get('email');

        if (empty($email)) {
            return new JsonResponse(['error' => 'Email is required'], Response::HTTP_BAD_REQUEST);
        }

        // Find the user by email
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            return new JsonResponse(['error' => 'No user found for this email'], Response::HTTP_NOT_FOUND);
        }

        // Generate a reset token and set the expiration
        $resetToken = $this->passwordResetService->createPasswordResetToken($user);

        // Send the reset email
        try {
            $this->sendResetEmail($user, $resetToken);
            return new JsonResponse(['message' => 'Password reset link sent.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Failed to send email.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function sendResetEmail(User $user, string $token)
    {
        $url = $this->generateUrl('password_reset_confirm', ['token' => $token], 0);
        $email = (new Email())
            ->from('no-reply@yourdomain.com')
            ->to($user->getEmail())
            ->subject('Password Reset Request')
            ->html(
                '<p>Click the link below to reset your password:</p><p><a href="' . $url . '">Reset Password</a></p>'
            );

        $this->mailer->send($email);
    }
}
```

### Étape 2 : Créer le service `PasswordResetService`.

Ce service va gérer la logique pour générer un token sécurisé, le stocker dans la base de données, et lier ce token à l'utilisateur.

#### 2.1 Créer le service.

```php
// src/Service/PasswordResetService.php
namespace App\Service;

use App\Entity\User;
use App\Entity\PasswordResetRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class PasswordResetService
{
    private $entityManager;
    private $tokenGenerator;

    public function __construct(EntityManagerInterface $entityManager, TokenGeneratorInterface $tokenGenerator)
    {
        $this->entityManager = $entityManager;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function createPasswordResetToken(User $user): string
    {
        // Generate a unique token
        $token = $this->tokenGenerator->generateToken();

        // Create a PasswordResetRequest entity to store the token and its expiration time
        $resetRequest = new PasswordResetRequest();
        $resetRequest->setUser($user);
        $resetRequest->setToken($token);
        $resetRequest->setExpiresAt(new \DateTime('+5 minutes')); // Token expires in 5 minutes

        // Persist the request in the database
        $this->entityManager->persist($resetRequest);
        $this->entityManager->flush();

        return $token;
    }

    public function validateResetToken(string $token): ?PasswordResetRequest
    {
        $resetRequest = $this->entityManager->getRepository(PasswordResetRequest::class)->findOneBy(['token' => $token]);

        if (!$resetRequest || $resetRequest->getExpiresAt() < new \DateTime()) {
            return null; // Token is either invalid or expired
        }

        return $resetRequest;
    }
}
```

### Étape 3 : Créer l'entité `PasswordResetRequest`.

Cette entité stockera les informations sur la demande de réinitialisation de mot de passe, comme le token et son expiration.

```php
// src/Entity/PasswordResetRequest.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PasswordResetRequestRepository")
 */
class PasswordResetRequest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="passwordResetRequests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expiresAt;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }
}
```

### Étape 4 : Créer la route de confirmation du token.

Enfin, nous allons créer une route qui permettra à l'utilisateur de valider son token, et s'il est valide et non expiré, il pourra réinitialiser son mot de passe.

```php
// src/Controller/PasswordResetController.php (Ajout à la classe existante)

    /**
     * @Route("/api/password-reset/{token}", name="password_reset_confirm", methods={"GET"})
     */
    public function confirmPasswordReset(string $token): JsonResponse
    {
        $resetRequest = $this->passwordResetService->validateResetToken($token);

        if (!$resetRequest) {
            return new JsonResponse(['error' => 'Invalid or expired token'], Response::HTTP_BAD_REQUEST);
        }

        // Token is valid, allow the user to reset the password (you can generate a new form or API endpoint for this)
        return new JsonResponse(['message' => 'Token is valid. Proceed to reset password.'], Response::HTTP_OK);
    }
```

### Étape 5 : Sécuriser l'envoi de l'email (facultatif).

Pour l'envoi d'email, vous pouvez utiliser le service `Mailer` de Symfony pour configurer votre email d'une manière plus avancée (personnalisation du contenu HTML, images embarquées, etc.).

---

### Résumé des étapes :
1. **Contrôleur** : `PasswordResetController` avec une méthode pour recevoir un email et envoyer un lien de réinitialisation.
2. **Service** : `PasswordResetService` pour générer un token unique et vérifier sa validité.
3. **Entité** : `PasswordResetRequest` pour stocker le token et sa date d'expiration.
4. **Confirmation du token** : Une route pour vérifier le token et permettre la réinitialisation.

