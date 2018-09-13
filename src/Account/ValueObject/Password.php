<?php


namespace App\Account\ValueObject;


use App\Tools\ValueObject\ValueObject;
use App\Tools\ValueObject\ValueObjectInterface;

final class Password implements ValueObjectInterface
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
        $regex = '/^[a-zA-Z0-9\`\~\!\@\#\$\%\^\&\*\(\)\_\+\-\=\[\]\\\;\,\.\/\'\{\}\|\:\"\<\>\?]{6,30}$/';
        if (!preg_match($regex, $value, $result)) {
            throw new \Exception('Invalid password');
        }

        return true;
    }

}