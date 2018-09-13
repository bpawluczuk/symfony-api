<?php

namespace App\Authentication;

use App\Authentication\Entity\AccountTokens;
use App\Tools\Manager\ManagerAbstract;
use DateTime;
use Firebase\JWT\JWT;

/**
 * Class ApiTokenManager
 * @package App\Authentication
 * @author Borys Pawluczuk
 */
class TokenManager extends ManagerAbstract
{
    /**
     * @param AccountDto $accountDto
     * @return AccountTokens
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function generateJwtToken(AccountDto $accountDto): AccountTokens
    {
        $accountTokens = new AccountTokens(
            $accountDto->getEmail()
        );

        $accountTokens
            ->setAccessToken($this->generateToken($accountDto));

        $entityManager = $this->getManager();
        $entityManager->persist($accountTokens);
        $entityManager->flush();

        return $accountTokens;
    }

    /**
     * @return DateTime
     */
    private function generateExpireDate(): DateTime
    {
        $expireDate = new DateTime();
        $expireDate->modify('+1 min');
        return $expireDate;
    }

    /**
     * @param string $token
     * @return bool
     */
    public function checkTokenIsValid(string $token): bool
    {
        try {
            $decodeToken = (array) JWT::decode($token, $this->getPublicKey(), array('RS256'));
            return $decodeToken['expiration'] > time() ? true : false;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param AccountDto $accountDto
     * @return string
     */
    private function generateToken(AccountDto $accountDto): string
    {
        $token = array(
            '_locale' => $accountDto->getLocale(),
            'expiration' => $this->generateExpireDate()->getTimestamp(),
            'firstname' => $accountDto->getFirstName(),
            'lastname' => $accountDto->getLastName(),
            'email' => $accountDto->getEmail(),
            'role' => ''
        );

        try {
            return JWT::encode($token, $this->getPrivateKey(), 'RS256');
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getPrivateKey()
    {
        return <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQDIBSovT8ooDGP6IA7CB/TMbBbTCuKAHJ2PG3/sv74lR1/jhv3x
mfiJkyV+yrUy4nkmsoiWQ4tww+2YHNpYncrPIC8XHpwBLwiR2syEBpEr4GF71pgG
AfxEWKKESR+fbSH5exrg1Ly7au7TL1NqpxKxu6rtRpV3aCLFg5RQVtIdIwIDAQAB
AoGBAIDjAxnVelhwE4Q7YAcbhVysUdDP9L/EsKpkd/wgWfA/m8RLWhtysbpEvSaE
jForoRGUfXsGLzYMqm8YOIJduy6y0Yz5ZB6BYdEuWZAGeYbidlcu5VAAw5Aum3c1
fqAGwezh4hbmad/jhlHj6b022+K+ZYMDCEOx06s+PfECwUoRAkEA/pEC8TQBYIo8
Cmdk0hzdL19kzAN3MxzR4Xi6N0CZeMAXw/GB/wNfn+O9TkUIRXJB/0eNwFd5J/pL
UbR6GZUvRwJBAMklhKitYtCc/lytoj3ju0ly7lVSgBnjHXAxq81iHJssc/tH6xuB
bafSUvV2mJi8cgzE8HCzuckOE6NDg3OmKUUCQFADVlBoDzK/4EVI4EimZ+M28aCq
SjIXkeRzpNwvAs4QWqfs5fY4ojrIQz0xt3rUgefyHpzhIaSuKDRjLKmT2YsCQFFQ
x4ZhQbdQIExbLWGTtN0Gh28awQq2E+qNSgTniuT4XZLSCiu+cRQNJNhyr1HfrMOY
whLttUegVzQDURrpq3kCQF5asXEf9T1My826yUN6Fxy3PdNAzUO1jJ56TMiLqaeo
uwYTJ2aNsdUfbv9X3U7VTnOsUnd6iMl1nATAgHVAxIc=
-----END RSA PRIVATE KEY-----
EOD;
    }

    public function getPublicKey()
    {
        return <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIBSovT8ooDGP6IA7CB/TMbBbT
CuKAHJ2PG3/sv74lR1/jhv3xmfiJkyV+yrUy4nkmsoiWQ4tww+2YHNpYncrPIC8X
HpwBLwiR2syEBpEr4GF71pgGAfxEWKKESR+fbSH5exrg1Ly7au7TL1NqpxKxu6rt
RpV3aCLFg5RQVtIdIwIDAQAB
-----END PUBLIC KEY-----
EOD;
    }
}