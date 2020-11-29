<?php

namespace App\Repository;

use App\Entity\PhoneBookEntry;
use App\Entity\SharedEntries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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

    public function findUserEntries(int $userId)
    {
        return $this->findBy(['fkUser' => $userId]);
    }

    public function findEntriesThatWereSharedByUser($userId)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin(PhoneBookEntry::class, 'p', Join::WITH, 's.fkPhoneBookEntry = p.id')
            ->andWhere('p.fkUser = :val')
            ->setParameter('val', $userId)
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
