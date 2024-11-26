<?php 
// tests/Entity/Stock/StockTest.php

namespace App\Tests\Entity\Stock;

use App\Entity\Stock\Stock;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DateTimeImmutable;

class StockTest extends TestCase
{
    public function testInitialValues()
    {
        $stock = new Stock();

        // Vérifier que l'ID est nul par défaut
        $this->assertNull($stock->getId());

        // Vérifier que la quantité disponible est nulle par défaut
        $this->assertNull($stock->getAivalableQuantity()); // Ou utilisez `availableQuantity` si vous avez corrigé l'orthographe

        // Vérifier que createdAt et updatedAt sont nulls par défaut
        $this->assertNull($stock->getCreatedAt());
        $this->assertNull($stock->getUpdatedAt());
    }

    public function testSetAndGetAivalableQuantity()
    {
        $stock = new Stock();

        // Vérifier l'accès à la propriété aivalableQuantity
        $stock->setAivalableQuantity('1000');
        $this->assertEquals('1000', $stock->getAivalableQuantity());
    }

    public function testCreatedAtAndUpdatedAt()
    {
        $stock = new Stock();

        // Créez un objet DateTimeImmutable pour comparer
        $now = new DateTimeImmutable();

        // Définir la date de création et la date de mise à jour
        $stock->setCreatedAt($now);
        $stock->setUpdatedAt($now);

        // Vérifier que createdAt et updatedAt ont été définis
        $this->assertEquals($now, $stock->getCreatedAt());
        $this->assertEquals($now, $stock->getUpdatedAt());
    }

    public function testBagRelationship()
    {
        // Création d'objets fictifs pour tester la relation ManyToMany
        $stock = new Stock();
        $bag1 = $this->createMock(\App\Entity\Stock\Bag::class);
        $bag2 = $this->createMock(\App\Entity\Stock\Bag::class);

        // Test de l'ajout de Bag
        $stock->addBag($bag1);
        $stock->addBag($bag2);

        // Vérifier que les bags sont bien ajoutés
        $this->assertCount(2, $stock->getBag());

        // Test de la suppression de Bag
        $stock->removeBag($bag1);

        // Vérifier que la collection de bags contient un seul élément après suppression
        $this->assertCount(1, $stock->getBag());
    }

    public function testConstructor()
    {
        $stock = new Stock();

        // Vérifier que la collection est bien initialisée
        $this->assertInstanceOf(Collection::class, $stock->getBag());
        $this->assertEmpty($stock->getBag());
    }
}
