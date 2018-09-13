<?php


namespace App\Tools\ValueObject;


interface ValueObjectInterface
{

    /**
     * ValueObjectInterface constructor.
     * @param $value
     */
    public function __construct($value);

    /**
     * @return mixed
     * @author Robert Glazer
     */
    public function __invoke();

    /**
     * @return string
     * @author Robert Glazer
     */
    public function __toString(): string;

    /**
     * @param $value
     * @return bool
     * @author Robert Glazer
     */
    public static function parseValue($value): bool;

    /**
     * @return mixed
     * @author Robert Glazer
     */
    public function get();

}