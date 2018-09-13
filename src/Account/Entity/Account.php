<?php

namespace App\Account\Entity;

use App\Account\ValueObject\Email;
use App\Account\ValueObject\FirstName;
use App\Account\ValueObject\LastName;
use App\Tools\Entity\CreatedAt;
use App\Tools\Entity\Id;
use App\Tools\Entity\Locale;
use App\Tools\Entity\UpdatedAt;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use JMS\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

/**
 * @ORM\Table(uniqueConstraints={@UniqueConstraint(name="account", columns={"email"})})
 * @ORM\Entity(repositoryClass="App\Account\Repository\AccountRepository")
 */
class Account
{

    use Id;
    use CreatedAt;
    use UpdatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="_locale", type="string", length=2)
     * @Groups({"api"})
     */
    private $_locale;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=100)
     *
     * @Groups({"api"})
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=100)
     *
     * @Groups({"api"})
     */
    private $lastName;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=64)
     *
     * @Groups({"api"})
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=255)
     *
     * @Groups({"api"})
     */
    private $password;

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->_locale;
    }

    /**
     * @param string $locale
     * @return Account
     */
    public function setLocale(string $locale): Account
    {
        $this->_locale = $locale;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Account
     */
    public function setPassword(string $password): Account
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return new Email($this->email);
    }

    /**
     * @param Email $email
     * @return Account
     */
    public function setEmail(Email $email): Account
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return LastName
     */
    public function getLastName(): LastName
    {
        return new LastName($this->lastName);
    }

    /**
     * @param LastName $lastName
     * @return Account
     */
    public function setLastName(LastName $lastName): Account
    {
        $this->lastName = (string)$lastName;
        return $this;
    }

    /**
     * @return FirstName
     */
    public function getFirstName(): FirstName
    {
        return new FirstName($this->firstName);
    }

    /**
     * @param mixed $firstName
     * @return Account
     */
    public function setFirstName(FirstName $firstName): Account
    {
        $this->firstName = (string)$firstName;
        return $this;
    }

}
