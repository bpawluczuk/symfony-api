<?php


namespace App\Tools\Entity;

/**
 * Trait Id
 * @package App\Tools\Entity
 */
trait Id
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @return int
     * @author Robert Glazer
     */
    public function getId(): int
    {
        return $this->id;
    }

}