<?php

namespace Sucre\Service\Phone;

/**
 * Class PhoneNumberService
 *
 * This class provides functionality to handle and validate phone numbers,
 * specifically for Madagascar. It supports formatting phone numbers in
 * E.164 format, validating their correctness based on specified rules,
 * and extracting local numbers and country codes.
 *
 * @package Sucre\Service\Phone
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class PhoneNumberService
{
    private string $phoneNumber;

    /**
     * Constructor to initialize the phone number.
     *
     * @param string $phoneNumber The phone number to be processed.
     */
    public function __construct(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Validate the phone number format.
     *
     * @return bool Returns true if the phone number is valid, false otherwise.
     */
    public function isValid(): bool
    {
        return preg_match('/^(?:\+261(34|32|33|37|38)\d{7}|(034|032|033|037|038)\d{7})$/', $this->phoneNumber) === 1;
    }

    /**
     * Format the phone number into E.164 format.
     *
     * @param string $format The desired format (default is 'E.164').
     * @return string The formatted phone number in E.164 format, or the original number if invalid.
     */
    public function format(string $format = 'E.164'): string
    {
        // Check if the phone number is in international format with +261
        if (preg_match('/^\+261(34|32|33|37|38)\d{7}$/', $this->phoneNumber)) {
            return str_replace('+', '', $this->phoneNumber); // Remove plus sign for E.164
        }
        // Check if the phone number is in local format
        elseif (preg_match('/^(034|032|033|037|038)\d{7}$/', $this->phoneNumber)) {
            // Format local number by adding +261 and removing the leading zero
            return '+261' . substr($this->phoneNumber, 1); // Remove leading zero
        }
        // Return the original phone number if it doesn't match expected formats
        return $this->phoneNumber;
    }

    /**
     * Get the country code.
     *
     * @return string The country code '261'.
     */
    public function getCountryCode(): string
    {
        return '261'; // Country code for Madagascar
    }

    /**
     * Check if the phone number is a local number.
     *
     * @param string $localPrefix The local prefix to check against.
     * @return bool Returns true if the number is local, false otherwise.
     */
    public function isLocal(string $localPrefix): bool
    {
        return str_starts_with($this->phoneNumber, $localPrefix);
    }

    /**
     * Get the local number without the country code.
     *
     * @return string The local phone number without the country code.
     */
    public function getLocalNumber(): string
    {
        return preg_replace('/^(?:\+261|261|0)?/', '', $this->phoneNumber);
    }

    /**
     * Convert the phone number to a string.
     *
     * @return string The phone number.
     */
    public function __toString(): string
    {
        return $this->phoneNumber;
    }
}
