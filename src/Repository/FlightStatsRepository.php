<?php

namespace App\Repository;

use App\Entity\FlightStats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FlightStats|null find($id, $lockMode = null, $lockVersion = null)
 * @method FlightStats|null findOneBy(array $criteria, array $orderBy = null)
 * @method FlightStats[]    findAll()
 * @method FlightStats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlightStatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FlightStats::class);
    }

    // /**
    //  * @return FlightStats[] Returns an array of FlightStats objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FlightStats
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
