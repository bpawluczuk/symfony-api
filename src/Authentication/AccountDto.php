<?php
/**
 * Created by PhpStorm.
 * User: bpawluczuk
 * Date: 07.09.2018
 * Time: 16:16
 */

namespace App\Authentication;

/**
 * Class AccountDto
 * @package App\Authentication
 * @author Borys Pawluczuk
 */
class AccountDto
{
    /**
     * @var string
     */
    private $_locale;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $email;

    /**
     * accountDto constructor.
     * @param string $_locale
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     */
    public function __construct(string $_locale, string $firstName, string $lastName, string $email)
    {
        $this->_locale = $_locale;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->_locale;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

}