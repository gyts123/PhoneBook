<?php

namespace App\Repository;

use App\Entity\SharedEntries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SharedEntries|null find($id, $lockMode = null, $lockVersion = null)
 * @method SharedEntries|null findOneBy(array $criteria, array $orderBy = null)
 * @method SharedEntries[]    findAll()
 * @method SharedEntries[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SharedEntriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SharedEntries::class);
    }

    public function findByUser(int $userId)
    {
        return $this->findBy(['fkUser' => $userId]);
    }

    // /**
    //  * @return ShatredEntries[] Returns an array of ShatredEntries objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShatredEntries
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
