<?php

namespace Sucre\Service\Human;

use InvalidArgumentException;

/**
 * Class CINService
 *
 * This class provides functionality to manage and validate a
 * "CIN" (Identification Number) which consists of exactly 12 digits.
 * It ensures the uniqueness of the CIN, validates its format,
 * formats it for storage, and provides methods to mask certain
 * parts of the CIN for privacy purposes. Additionally, it can
 * retrieve location information based on the CIN's postal code.
 *
 * @package Sucre\Service\Human
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class CINService
{
    private string $cin;
    private static array $existingCINs = []; // To store existing CINs for uniqueness check

    /**
     * CINService constructor.
     *
     * @param string $cin The CIN to validate and manage.
     *
     * @throws InvalidArgumentException If the CIN is invalid.
     */
    public function __construct(string $cin)
    {
        if (!$this->isValidCIN($cin)) {
            throw new InvalidArgumentException("The CIN must be unique and have exactly 12 digits.");
        }

        $this->cin = $cin;
        self::$existingCINs[] = $cin; // Store the new CIN
    }

    /**
     * Validates the CIN.
     *
     * This method checks if the provided CIN has exactly 12 digits,
     * is formatted correctly, and is unique (not already existing).
     *
     * @param string $cin The CIN to validate.
     * @return bool True if the CIN is valid, otherwise false.
     */
    private function isValidCIN(string $cin): bool
    {
        // Check if the CIN is unique and has exactly 12 digits
        return preg_match('/^\d{3}\s\d{3}\s\d{3}\s\d{3}$/', $cin) && !in_array($cin, self::$existingCINs);
    }

    /**
     * Formats the CIN by removing spaces.
     *
     * This method returns the CIN without any spaces,
     * ensuring a clean representation for further processing.
     *
     * @return string The formatted CIN.
     */
    public function formatCIN(): string
    {
        return preg_replace('/\s+/', '', $this->cin);
    }





    /**
     * Checks the location based on the first three digits of the CIN.
     *
     * This method extracts the first three digits of the CIN,
     * uses them to look up corresponding location details,
     * and returns them in an associative array.
     * If no matching location is found, a message indicating unknown location is returned.
     *
     * @return array An associative array containing location details or a message for unknown locations.
     */
    public function checkLocation(): array
    {
        $code = substr($this->cin, 0, 3);
        $details = $this->getPostalCodeDetails($code);

        if (empty($details)) {
            return ['message' => 'Unknown location'];
        }

        return [
            'zone' => $details['zone'],
            'city' => $details['city'] ?? 'N/A',
            'region_1' => $details['region_1'] ?? 'N/A',
            'region_2' => $details['region_2'] ?? 'N/A',
            'region_3' => $details['region_3'] ?? 'N/A',
            'country' => $details['country'] ?? 'N/A',
            'postal_code' => $details['postal_code'] ?? 'N/A',
        ];
    }

    /**
     * Hides digits from the 4th to the 10th position.
     *
     * This method masks the digits between the 4th and 10th positions
     * of the CIN with asterisks for privacy protection.
     *
     * @return string The CIN with hidden digits.
     */
    public function hideCIN(): string
    {
        //Removes spaces to ensure the right format
        $cleanCIN = str_replace(' ', '', $this->cin);

        // Hide the numbers from 4th to 9th position
        return substr($cleanCIN, 0, 3) . '****' . substr($cleanCIN, 9); // Prendre les 3 premiers, puis les derniers chiffres
    }

    /**
     * Retrieves postal code details based on the provided postal code.
     *
     * This private method looks up the details for a given postal code,
     * returning an associative array containing location information
     * such as zone, region, and province.
     *
     * @param string $code The postal code to retrieve details for.
     * @return array An associative array containing postal code details.
     */
    private function getPostalCodeDetails(string $code): array
    {
        $postalCodes = [
            // Madagascar - Antananarivo region
            '101' => ['zone' => 'Antananarivo', 'region' => 'Antananarivo', 'province' => 'Analamanga'],
            '102' => ['zone' => 'Antananarivo Sud', 'region' => 'Antananarivo', 'province' => 'Analamanga'],
            '103' => ['zone' => 'Antananarivo Nord', 'region' => 'Antananarivo', 'province' => 'Analamanga'],
            '104' => ['zone' => 'Ambatolampy', 'region' => 'Antananarivo', 'province' => 'Vakinankaratra'],
            '105' => ['zone' => 'Ambohidratrimo', 'region' => 'Antananarivo', 'province' => 'Analamanga'],
            '106' => ['zone' => 'Andramasina', 'region' => 'Antananarivo', 'province' => 'Analamanga'],
            '107' => ['zone' => 'Anjozorobe', 'region' => 'Antananarivo', 'province' => 'Analamanga'],
            '108' => ['zone' => 'Ankazobe', 'region' => 'Antananarivo', 'province' => 'Analamanga'],
            '115' => ['zone' => 'Fenoarivo Centre', 'region' => 'Antananarivo', 'province' => 'Bongolava'],
            '119' => ['zone' => 'Tsiroanomandidy', 'region' => 'Antananarivo', 'province' => 'Bongolava'],
            '112' => ['zone' => 'Arivonimamo', 'region' => 'Antananarivo', 'province' => 'Itasy'],
            '117' => ['zone' => 'Miarinarivo', 'region' => 'Antananarivo', 'province' => 'Itasy'],
            '118' => ['zone' => 'Soavinandriana', 'region' => 'Antananarivo', 'province' => 'Itasy'],
            '111' => ['zone' => 'Antsirabe Rural', 'region' => 'Antananarivo', 'province' => 'Vakinankaratra'],
            '110' => ['zone' => 'Antsirabe Urban', 'region' => 'Antananarivo', 'province' => 'Vakinankaratra'],
            '113' => ['zone' => 'Betafo', 'region' => 'Antananarivo', 'province' => 'Vakinankaratra'],
            '114' => ['zone' => 'Faratsiho', 'region' => 'Antananarivo', 'province' => 'Vakinankaratra'],

            // Madagascar - Antsiranana region
            '201' => ['zone' => 'Antsiranana Urban', 'region' => 'Antsiranana', 'province' => 'Diana'],
            '202' => ['zone' => 'Antsiranana Rural', 'region' => 'Antsiranana', 'province' => 'Diana'],
            '203' => ['zone' => 'Ambanja', 'region' => 'Antsiranana', 'province' => 'Diana'],
            '204' => ['zone' => 'Ambilobe', 'region' => 'Antsiranana', 'province' => 'Diana'],
            '205' => ['zone' => 'Andapa', 'region' => 'Antsiranana', 'province' => 'Sava'],
            '206' => ['zone' => 'Antalaha', 'region' => 'Antsiranana', 'province' => 'Sava'],
            '207' => ['zone' => 'Nosy Be', 'region' => 'Antsiranana', 'province' => 'Diana'],
            '208' => ['zone' => 'Sambava', 'region' => 'Antsiranana', 'province' => 'Sava'],
            '209' => ['zone' => 'Vohimarina (Iharana)', 'region' => 'Antsiranana', 'province' => 'Sava'],

            // Madagascar - Fianarantsoa region
            '301' => ['zone' => 'Fianarantsoa Urban', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '302' => ['zone' => 'Fianarantsoa Rural', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '303' => ['zone' => 'Ambalavao', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '304' => ['zone' => 'Ambatofinandrahana', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '305' => ['zone' => 'Ambohimahasoa', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '306' => ['zone' => 'Ambositra', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '307' => ['zone' => 'Befotaka', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '308' => ['zone' => 'Fandriana', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '309' => ['zone' => 'Farafangana', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '310' => ['zone' => 'Ikongo', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '311' => ['zone' => 'Iakora', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '312' => ['zone' => 'Ifanadiana', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '313' => ['zone' => 'Ihosy', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '314' => ['zone' => 'Ikalamavony', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '315' => ['zone' => 'Ivohibe', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '316' => ['zone' => 'Manakara Sud', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '317' => ['zone' => 'Mananjary', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '318' => ['zone' => 'Midongy Sud', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '319' => ['zone' => 'Nosy Varika', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '320' => ['zone' => 'Vangaindrano', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '321' => ['zone' => 'Vohipeno', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],
            '322' => ['zone' => 'Vondrozo', 'region' => 'Fianarantsoa', 'province' => 'Fianarantsoa'],

            // Madagascar - Mahajanga region (similar to Fianarantsoa)
            '401' => ['zone' => 'Mahajanga Urban', 'region' => 'Mahajanga', 'province' => 'Mahajanga'],
            '402' => ['zone' => 'Mahajanga Rural', 'region' => 'Mahajanga', 'province' => 'Mahajanga'],
            '403' => ['zone' => 'Befandriana', 'region' => 'Mahajanga', 'province' => 'Mahajanga'],
            '404' => ['zone' => 'Mahalavolona', 'region' => 'Mahajanga', 'province' => 'Mahajanga'],
            '405' => ['zone' => 'Antsohihy', 'region' => 'Mahajanga', 'province' => 'Mahajanga'],
            '406' => ['zone' => 'Tsaratanana', 'region' => 'Mahajanga', 'province' => 'Mahajanga'],
            '407' => ['zone' => 'Ambato-Boeni', 'region' => 'Mahajanga', 'province' => 'Mahajanga'],
            '408' => ['zone' => 'Amborovy', 'region' => 'Mahajanga', 'province' => 'Mahajanga'],

            // Madagascar - Toamasina region
            '501' => ['zone' => 'Toamasina Urban', 'region' => 'Toamasina', 'province' => 'Toamasina'],
            '502' => ['zone' => 'Toamasina Rural', 'region' => 'Toamasina', 'province' => 'Toamasina'],
            '503' => ['zone' => 'Ambatondrazaka', 'region' => 'Toamasina', 'province' => 'Atsinanana'],
            '504' => ['zone' => 'Amparafaravola', 'region' => 'Toamasina', 'province' => 'Atsinanana'],
            '505' => ['zone' => 'Andilamena', 'region' => 'Toamasina', 'province' => 'Atsinanana'],
            '506' => ['zone' => 'Anosibe', 'region' => 'Toamasina', 'province' => 'Atsinanana'],
            '507' => ['zone' => 'Antanambao Manampotsy', 'region' => 'Toamasina', 'province' => 'Atsinanana'],
            '508' => ['zone' => 'Ampasimanolotra', 'region' => 'Toamasina', 'province' => 'Atsinanana'],
            '509' => ['zone' => 'Fenoarivo Atsinanana', 'region' => 'Toamasina', 'province' => 'Atsinanana'],
            '510' => ['zone' => 'Mahanoro', 'region' => 'Toamasina', 'province' => 'Atsinanana'],
            '511' => ['zone' => 'Mananara', 'region' => 'Toamasina', 'province' => 'Atsinanana'],
            '512' => ['zone' => 'Maroansetra', 'region' => 'Toamasina', 'province' => 'Atsinanana'],
            '513' => ['zone' => 'Marolambo', 'region' => 'Toamasina', 'province' => 'Atsinanana'],
            '514' => ['zone' => 'Moramanga', 'region' => 'Toamasina', 'province' => 'Atsinanana'],
            '515' => ['zone' => 'Nosy-Boraha (Ste Marie)', 'region' => 'Toamasina', 'province' => 'Atsinanana'],
            '516' => ['zone' => 'Soanierana-Ivongo', 'region' => 'Toamasina', 'province' => 'Atsinanana'],
            '517' => ['zone' => 'Vatomandry', 'region' => 'Toamasina', 'province' => 'Atsinanana'],
            '518' => ['zone' => 'Vavatenina', 'region' => 'Toamasina', 'province' => 'Atsinanana'],

            // Madagascar - Toliara region
            '601' => ['zone' => 'Toliara Urban', 'region' => 'Toliara', 'province' => 'Toliara'],
            '602' => ['zone' => 'Toliara Rural', 'region' => 'Toliara', 'province' => 'Toliara'],
            '603' => ['zone' => 'Amboasary Sud', 'region' => 'Toliara', 'province' => 'Androy'],
            '604' => ['zone' => 'Ambovombe-Androy', 'region' => 'Toliara', 'province' => 'Androy'],
            '605' => ['zone' => 'Ampanihy', 'region' => 'Toliara', 'province' => 'Androy'],
            '606' => ['zone' => 'Ankazoabo Sud', 'region' => 'Toliara', 'province' => 'Androy'],
            '607' => ['zone' => 'Bekily', 'region' => 'Toliara', 'province' => 'Androy'],
            '608' => ['zone' => 'Belon-i Tsiribihina', 'region' => 'Toliara', 'province' => 'Menabe'],
            '609' => ['zone' => 'Beloha', 'region' => 'Toliara', 'province' => 'Androy'],
            '610' => ['zone' => 'Benenitra', 'region' => 'Toliara', 'province' => 'Atsimo-Andrefana'],
            '611' => ['zone' => 'Beroroha', 'region' => 'Toliara', 'province' => 'Atsimo-Andrefana'],
            '612' => ['zone' => 'Betioky Sud', 'region' => 'Toliara', 'province' => 'Atsimo-Andrefana'],
            '613' => ['zone' => 'Betroka', 'region' => 'Toliara', 'province' => 'Atsimo-Andrefana'],
            '614' => ['zone' => 'Taolagnaro', 'region' => 'Toliara', 'province' => 'Anosy'],
            '615' => ['zone' => 'Mahabo', 'region' => 'Toliara', 'province' => 'Atsimo-Andrefana'],
            '616' => ['zone' => 'Manja', 'region' => 'Toliara', 'province' => 'Atsimo-Andrefana'],
            '617' => ['zone' => 'Miandrivazo', 'region' => 'Toliara', 'province' => 'Menabe'],
            '618' => ['zone' => 'Morombe', 'region' => 'Toliara', 'province' => 'Atsimo-Andrefana'],
            '619' => ['zone' => 'Morondava', 'region' => 'Toliara', 'province' => 'Menabe'],
            '620' => ['zone' => 'Sakaraha', 'region' => 'Toliara', 'province' => 'Atsimo-Andrefana'],
            '621' => ['zone' => 'Tsiombe', 'region' => 'Toliara', 'province' => 'Atsimo-Andrefana'],
        ];

        return $postalCodes[$code] ?? [];
    }
}
