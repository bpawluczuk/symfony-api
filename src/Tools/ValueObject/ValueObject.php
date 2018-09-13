<?php


namespace App\Tools\ValueObject;


trait ValueObject
{

    /**
     * @var mixed
     */
    private $value;

    /**
     * ValueObject constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->parseValue($value);
        $this->value = $value;
    }

    /**
     * @return mixed
     * @author Robert Glazer
     */
    public function __invoke()
    {
        return $this->value;
    }

    /**
     * @return string
     * @author Robert Glazer
     */
    public function __toString(): string
    {
        return (string)$this->value;
    }

    /**
     * @param $value
     * @return bool
     * @author Robert Glazer
     */
    public static abstract function parseValue($value): bool;

    /**
     * @return mixed
     * @author Robert Glazer
     */
    public function get() {
        return $this->value;
    }

}