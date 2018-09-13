<?php

namespace App\Account\Security;

/**
 * Class PasswordEncoder
 * @package App\Account\Security
 */
class PasswordEncoder
{
    /**
     * Encodes the raw password.
     *
     * @param string $raw The password to encode
     *
     * @return string The encoded password
     */
    public static function encodePassword($raw)
    {
        return password_hash($raw, PASSWORD_BCRYPT);
    }

    /**
     * Checks a raw password against an encoded password.
     *
     * @param string $encoded An encoded password
     * @param string $raw A raw password
     *
     * @return bool true if the password is valid, false otherwise
     */
    public static function isPasswordValid($encoded, $raw)
    {
        return password_verify($raw, $encoded);
    }

}