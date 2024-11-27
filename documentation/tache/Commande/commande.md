## Commande

### 1. **Structure des Entités**

#### 1.1. Entité **Commande**
La première étape consiste à définir l'entité `Commande` en PHP avec les relations nécessaires.

```php
// src/Entity/Commande.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="commande")
 */
class Commande
{
    // Déclaration des propriétés
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bag")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bag;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeRiz")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeRiz;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $statut;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull()
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull()
     */
    private $dateModification;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresseLivraison;

    // Getter et Setters...
}
```

#### 1.2. Entité **TypeRiz**
Le type de riz doit être un modèle pour calculer le prix de base de chaque sac de riz.

```php
// src/Entity/TypeRiz.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="type_riz")
 */
class TypeRiz
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $prixBase;

    // Getter et Setters...
}
```

#### 1.3. Entité **Bag** (Sac de riz)

```php
// src/Entity/Bag.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bag")
 */
class Bag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    // Getter et Setters...
}
```

### 2. **Création des Endpoints**

API Platform permet de générer automatiquement des endpoints RESTful pour les entités Doctrine, vous n'avez donc pas besoin de créer manuellement les contrôleurs. Vous pouvez les configurer avec des annotations ou des attributs PHP, comme suit :

#### 2.1. Endpoint pour **Commande**

```php
// src/Entity/Commande.php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_VENDEUR')"},
 *         "post"={}
 *     },
 *     itemOperations={
 *         "get"={"security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_VENDEUR')"},
 *         "put"={"security"="is_granted('ROLE_CLIENT') and object.client == user"},
 *         "delete"={"security"="is_granted('ROLE_ADMIN')"}
 *     }
 * )
 */
class Commande
{
    // Les autres propriétés de l'entité
}
```

### 3. **Gestion des Commandes**

- **Annulation des Commandes** : 
  Ajoutez un attribut `annulée` au statut de la commande. Par défaut, l’état est "en cours", mais il peut être mis à "annulée" ou "livrée" par l'utilisateur ou l'administrateur.
  
- **Modification des Commandes** :
  Vous pouvez ajouter une logique de validation pour empêcher les modifications si la date de livraison est dépassée.

```php
// src/EventListener/CommandeListener.php

namespace App\EventListener;

use App\Entity\Commande;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Doctrine\ORM\EntityManagerInterface;

class CommandeListener
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $commande = $this->entityManager->getRepository(Commande::class)->find($request->get('id'));

        // Vérifier si la date de livraison est dépassée
        $dateLivraison = $commande->getDateLivraison();
        if ($dateLivraison < new \DateTime()) {
            throw new \Exception("La commande ne peut pas être modifiée après la date de livraison.");
        }
    }
}
```

### 4. **Statuts des Commandes**

Les statuts "en cours", "annulée", et "livrée" sont simples à implémenter, en stockant cette valeur sous forme de chaîne dans la base de données. Vous pouvez aussi ajouter une logique métier pour gérer la transition de statut.

#### Exemple de code pour la mise à jour du statut :

```php
// src/Controller/CommandeController.php

namespace App\Controller;

use App\Entity\Commande;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class CommandeController
{
    public function updateStatut(int $id, string $statut, EntityManagerInterface $entityManager): Response
    {
        $commande = $entityManager->getRepository(Commande::class)->find($id);

        if (!$commande) {
            return new Response("Commande non trouvée", 404);
        }

        $commande->setStatut($statut);
        $entityManager->flush();

        return new Response("Statut mis à jour", 200);
    }
}
```

### 5. **Sécurisation des Accès**

- **Seuls les administrateurs et les vendeurs peuvent voir toutes les commandes.**
- **Les clients peuvent uniquement voir leurs propres commandes.**
- **La modification des commandes est restreinte selon les règles de dates.**

Cela peut être facilement géré par des annotations de sécurité dans API Platform, comme montré dans l'exemple de l'entité `Commande` précédemment.

### Conclusion

Avec cette structure, vous avez une API complète pour gérer le système de commandes de riz. Le modèle suit les règles que vous avez définies, tout en s'assurant que les clients ne peuvent pas modifier ou annuler des commandes après la date de livraison, et que seuls les utilisateurs autorisés peuvent consulter ou modifier les commandes. Il vous reste à configurer la sécurité et la gestion des utilisateurs (roles et permissions).
