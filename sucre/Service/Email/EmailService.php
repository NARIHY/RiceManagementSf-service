<?php

namespace Sucre\Service\Email;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use InvalidArgumentException;

/**
 * Class EmailService
 *
 * Manages operations related to email, including validation.
 *
 * @package Sucre\Service\Email
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class EmailService
{
    /**
     * @var string The validated email.
     */
    private string $email;

    /**
     * EmailService constructor.
     *
     * @param string $email The email to validate.
     *
     * @throws InvalidArgumentException If the email is invalid.
     */
    public function __construct(string $email)
    {
        if (!$this->isValidEmail($email)) {
            throw new InvalidArgumentException("The provided email is invalid.");
        }
        $this->email = $email;
    }

    /**
     * Retrieves the validated email.
     *
     * @return string The validated email.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Checks if the email is valid.
     *
     * @param string $email The email to validate.
     *
     * @return bool True if the email is valid, false otherwise.
     */
    private function isValidEmail(string $email): bool
    {
        $validator = new EmailValidator();
        $multipleValidations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation()
        ]);
        return $validator->isValid($email, $multipleValidations);
    }

    // Add other email-related methods here
}
