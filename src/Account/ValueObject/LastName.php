<?php


namespace App\Account\ValueObject;

use App\Tools\ValueObject\ValueObject;
use App\Tools\ValueObject\ValueObjectInterface;

final class LastName implements ValueObjectInterface
{

    use ValueObject;

    /**
     * @param mixed $value
     * @return bool
     * @throws \Exception
     * @author Robert Glazer
     */
    public static function parseValue($value): bool
    {
        $regex = '/^[a-ząęółśżźćńA-ZĄĘÓŁŚŻŹĆŃ\s\-]{3,100}$/';
        if (!preg_match($regex, $value, $result)) {
            throw new \Exception('Last name is invalid');
        }

        return true;
    }


}