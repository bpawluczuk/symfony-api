<?php
/**
 * Created by PhpStorm.
 * User: bpawluczuk
 * Date: 14.09.2018
 * Time: 14:47
 */

namespace App\Products\Entity;

use App\Tools\Entity\CreatedAt;
use App\Tools\Entity\Id;
use App\Tools\Entity\UpdatedAt;
use DateTime;
use Swagger\Annotations as SWG;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Nelmio\ApiDocBundle\Annotation\Model;
use JMS\Serializer\Annotation\Groups;

/**
 * Class Product
 * @package App\Product\Entity
 * @author Borys Pawluczuk
 * @ORM\Table(uniqueConstraints={@UniqueConstraint(name="code", columns={"code"})})
 * @ORM\Entity(repositoryClass="App\Products\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="code", type="string", length=32)
     *
     * @Groups({"api"})
     */
    private $code;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=100)
     *
     * @Groups({"api"})
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     *
     * @Groups({"api"})
     */
    private $price;

    /**
     * @var string
     * @ORM\Column(name="currency", type="string", length=100)
     *
     * @Groups({"api"})
     */
    private $currency;

    /**
     * Product constructor.
     * @param string $_locale
     * @param string $code
     * @param string $name
     * @param string $price
     * @param string $currency
     */
    public function __construct(string $_locale, string $code, string $name, string $price, string $currency)
    {
        $this->_locale = $_locale;
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
        $this->currency = $currency;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

}