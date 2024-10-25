<?php

namespace App\Repository;

use App\Entity\TokenBlacklist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TokenBlacklist>
 */
class TokenBlacklistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TokenBlacklist::class);
    }

    //    /**
    //     * @return TokenBlacklist[] Returns an array of TokenBlacklist objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TokenBlacklist
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function addToken(string $token): void {
        $blacklistedToken = new TokenBlacklist($token);
        $this->_em->persist($blacklistedToken);
        $this->_em->flush();
    }

    public function isTokenBlacklisted(string $token): bool {
        return (bool) $this->findOneBy(['token' => $token]);
    }
}
