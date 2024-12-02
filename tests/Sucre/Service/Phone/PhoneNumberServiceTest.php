<?php

use PHPUnit\Framework\TestCase;
use Sucre\Service\Phone\PhoneNumberService;

class PhoneNumberServiceTest extends TestCase
{
    /**
     * Test que la validation fonctionne pour un numéro valide international
     */
    public function testValidInternationalNumber()
    {
        $validPhone = new PhoneNumberService('+261344567890');
        $this->assertTrue($validPhone->isValid(), "Le numéro international +26134456789 devrait être valide.");
    }

    /**
     * Test que la validation fonctionne pour un numéro valide local
     */
    public function testValidLocalNumber()
    {
        $validPhone = new PhoneNumberService('0344567891');
        $this->assertTrue($validPhone->isValid(), "Le numéro local 034456789 devrait être valide.");
    }

    /**
     * Test que la validation échoue pour un numéro invalide
     */
    public function testInvalidNumber()
    {
        // Nous nous attendons à ce qu'une exception soit lancée pour un numéro invalide
        $this->expectException(\InvalidArgumentException::class);

        // Tenter de créer un objet avec un numéro invalide
        new PhoneNumberService('01234567');
    }


    /**
     * Test que le formatage fonctionne pour un numéro valide international
     */
    public function testFormatInternationalNumber()
    {
        $validPhone = new PhoneNumberService('+261344567899');
        $this->assertEquals('+261344567899', $validPhone->format(), "Le numéro +261344567899 doit être déjà en format E.164.");
    }

    /**
     * Test que le formatage fonctionne pour un numéro local en ajoutant le code pays
     */
    public function testFormatLocalNumber()
    {
        $localPhone = new PhoneNumberService('0344567899');
        $this->assertEquals('+261344567899', $localPhone->format(), "Le numéro local 0344567899 doit être converti en format E.164.");
    }

    /**
     * Test que le formatage échoue pour un numéro invalide
     */
    public function testFormatInvalidNumber()
    {
        $this->expectException(\InvalidArgumentException::class);
        $invalidPhone = new PhoneNumberService('01234567');
    }

    /**
     * Test que la méthode getCountryCode retourne le bon code pays
     */
    public function testGetCountryCode()
    {
        $phone = new PhoneNumberService('+261344567899');
        $this->assertEquals('261', $phone->getCountryCode(), "Le code pays pour Madagascar doit être '261'.");
    }

    /**
     * Test que la méthode isLocal fonctionne pour un numéro local
     */
    public function testIsLocal()
    {
        $phone = new PhoneNumberService('0344567899');
        $this->assertTrue($phone->isLocal('034'), "Le numéro 034456789 doit être local.");
    }

    /**
     * Test que la méthode getLocalNumber fonctionne pour un numéro local
     */
    public function testGetLocalNumber()
    {
        $phone = new PhoneNumberService('+261344567899');
        $this->assertEquals('344567899', $phone->getLocalNumber(), "Le numéro local extrait doit être 34456789.");
    }

    /**
     * Test que la méthode getLocalNumber fonctionne pour un numéro local sans code pays
     */
    public function testGetLocalNumberWithoutCountryCode()
    {
        $phone = new PhoneNumberService('0344567899');
        $this->assertEquals('344567899', $phone->getLocalNumber(), "Le numéro local extrait sans code pays doit être 34456789.");
    }

    /**
     * Test que le constructeur lance une exception pour un numéro invalide
     */
    public function testConstructorThrowsExceptionOnInvalidNumber()
    {
        $this->expectException(InvalidArgumentException::class);
        new PhoneNumberService('01234567');
    }

    /**
     * Test que le formatage d'un numéro invalide ne modifie pas le numéro
     */
    public function testFormatInvalidNumberNoChange()
    {
        $this->expectException(InvalidArgumentException::class);
        $invalidPhone = new PhoneNumberService('01234567');
    }
}
