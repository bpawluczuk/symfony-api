<?php


namespace App\Account\ValueObject;


use App\Tools\ValueObject\ValueObject;
use App\Tools\ValueObject\ValueObjectInterface;

final class Email implements ValueObjectInterface
{

    use ValueObject;

    /**
     * @param string $value
     * @return bool
     * @throws \Exception
     * @author Robert Glazer
     */
    public static function parseValue($value): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Invalid email: ' . $value);
        }

        return true;
    }

}