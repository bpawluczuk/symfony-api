<?php

namespace App\Authentication\Entity;

use App\Entity\BaseEntity;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

/**
 * Class UserTokens
 * @package App\Authentication\Entity
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Authentication\Repository\AccountTokensRepository")
 */
class AccountTokens extends BaseEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="access_token", type="text")
     */
    private $accessToken;

    /**
     * AccountTokens constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set accessToken
     *
     * @param string $accessToken
     * @return AccountTokens
     */
    public function setAccessToken($accessToken): AccountTokens
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get accessToken
     *
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

}
