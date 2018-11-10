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
 * @ORM\Entity(repositoryClass="App\Products\Repository\ProductRepository")
 */
class Product
{
    use Id;
    use CreatedAt;
    use UpdatedAt;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=100)
     *
     * @Groups({"api"})
     */
    private $name;


    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

}