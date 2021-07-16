<?php

namespace App\Repository;

use App\Entity\OrderAuditLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderAuditLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderAuditLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderAuditLog[]    findAll()
 * @method OrderAuditLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderAuditLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderAuditLog::class);
    }

    // /**
    //  * @return OrderAuditLog[] Returns an array of OrderAuditLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderAuditLog
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
