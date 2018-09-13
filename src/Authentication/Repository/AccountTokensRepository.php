<?php

namespace App\Authentication\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class AccountTokensRepository
 * @package App\Authentication\Repository
 */
class AccountTokensRepository extends EntityRepository
{
    /**
     * @param string $token
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @author Robert Glazer
     */
    public function checkAccessTokenIsValid($token)
    {
        $dateTimeNow = new \DateTime();

        $queryBuilder = $this->createQueryBuilder('ut');
        $queryBuilder
            ->select('ut')
            ->where('ut.accessToken = :token')
            ->andWhere('ut.accessTokenExpireDate > :dateNow')
            ->setParameters([
                'token' => $token,
                'dateNow' => $dateTimeNow,
            ]);

        $userTokens = $queryBuilder->getQuery()->getOneOrNullResult();
        if (empty($userTokens)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $token
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @author Robert Glazer
     */
    public function checkRefreshTokenIsValid($token)
    {
        $dateTimeNow = new \DateTime();

        $queryBuilder = $this->createQueryBuilder('ut');
        $queryBuilder
            ->select('ut')
            ->where('ut.refreshToken = :token')
            ->andWhere('ut.refreshTokenExpireDate > :dateNow')
            ->setParameters([
                'token' => $token,
                'dateNow' => $dateTimeNow,
            ]);

        $userTokens = $queryBuilder->getQuery()->getOneOrNullResult();
        if (empty($userTokens)) {
            return false;
        }

        return true;
    }

}
