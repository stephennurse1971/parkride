<?php

namespace App\Repository;

use App\Entity\FlightDestinations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FlightDestinations>
 *
 * @method FlightDestinations|null find($id, $lockMode = null, $lockVersion = null)
 * @method FlightDestinations|null findOneBy(array $criteria, array $orderBy = null)
 * @method FlightDestinations[]    findAll()
 * @method FlightDestinations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlightDestinationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FlightDestinations::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(FlightDestinations $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(FlightDestinations $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return FlightDestinations[] Returns an array of FlightDestinations objects
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
    public function findOneBySomeField($value): ?FlightDestinations
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
