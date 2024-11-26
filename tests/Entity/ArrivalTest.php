<?php
// tests/Entity/Stock/ArrivalTest.php
namespace App\Tests\Entity\Stock;

use App\Entity\Stock\Arrival;
use App\Entity\Stock\Bag;
use App\Entity\Stock\Status;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

class ArrivalTest extends TestCase
{
    public function testSettersAndGetters()
    {
        $arrival = new Arrival();

        // Test setter and getter for labelName
        $arrival->setLabelName('Arrival 1');
        $this->assertEquals('Arrival 1', $arrival->getLabelName());

        // Test setter and getter for arrivalDate
        $arrivalDate = new \DateTime('2024-11-26 10:00:00');
        $arrival->setArrivalDate($arrivalDate);
        $this->assertEquals($arrivalDate, $arrival->getArrivalDate());

        // Test setter and getter for bagPrice
        $arrival->setBagPrice(100.50);
        $this->assertEquals(100.50, $arrival->getBagPrice());

        // Test setter and getter for status
        $status = new Status();
        $arrival->setStatus($status);
        $this->assertEquals($status, $arrival->getStatus());

        // Test setter and getter for bag
        $bag = new Bag();
        $arrival->setBag($bag);
        $this->assertEquals($bag, $arrival->getBag());
    }

    public function testPrePersist()
    {
        $arrival = new Arrival();
        $arrival->onPrePersist(); // Call the method that sets createdAt and updatedAt

        $this->assertInstanceOf(\DateTimeImmutable::class, $arrival->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $arrival->getUpdatedAt());
    }

    public function testPreUpdate()
    {
        $arrival = new Arrival();
        $arrival->onPreUpdate(); // Call the method that updates updatedAt

        $this->assertInstanceOf(\DateTimeImmutable::class, $arrival->getUpdatedAt());
    }
}
