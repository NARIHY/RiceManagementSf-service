<?php 
// tests/Entity/Stock/BagTest.php
namespace App\Tests\Entity\Stock;

use App\Entity\Stock\Bag;
use App\Entity\Stock\Arrival;
use App\Entity\Stock\Stock;
use PHPUnit\Framework\TestCase;

class BagTest extends TestCase
{
    public function testSettersAndGetters()
    {
        $bag = new Bag();

        // Test setter and getter for quantity
        $bag->setQuantity('10');
        $this->assertEquals('10', $bag->getQuantity());

        // Test getter for arrivals (should be empty at first)
        $this->assertCount(0, $bag->getArrivals());

        // Test getter for stock (should be empty at first)
        $this->assertCount(0, $bag->getStock());
    }

    public function testAddAndRemoveArrival()
    {
        $bag = new Bag();
        $arrival = new Arrival();

        // Add arrival to bag
        $bag->addArrival($arrival);
        $this->assertCount(1, $bag->getArrivals());
        $this->assertSame($bag, $arrival->getBag()); // Check that the arrival's bag is set

        // Remove arrival from bag
        $bag->removeArrival($arrival);
        $this->assertCount(0, $bag->getArrivals());
    }

    public function testAddAndRemoveStock()
    {
        $bag = new Bag();
        $stock = new Stock();

        // Add stock to bag
        $bag->addStock($stock);
        $this->assertCount(1, $bag->getStock());

        // Remove stock from bag
        $bag->removeStock($stock);
        $this->assertCount(0, $bag->getStock());
    }

    public function testPrePersist()
    {
        $bag = new Bag();
        $bag->onPrePersist(); // Call the method that sets createdAt and updateAt

        $this->assertInstanceOf(\DateTimeImmutable::class, $bag->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $bag->getUpdateAt());
    }

    public function testPreUpdate()
    {
        $bag = new Bag();
        $bag->onPreUpdate(); // Call the method that updates updateAt

        $this->assertInstanceOf(\DateTimeImmutable::class, $bag->getUpdateAt());
    }
}

