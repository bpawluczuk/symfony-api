<?php
/**
 * Created by PhpStorm.
 * User: bpawluczuk
 * Date: 10/11/2018
 * Time: 10:29
 */

namespace App\Products\CQRS\command;

/**
 * Class CreateProductCommand
 * @package App\CQRS\command
 */
class CreateProductCommand
{
    private $name;

    /**
     * CreateProductCommand constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

}