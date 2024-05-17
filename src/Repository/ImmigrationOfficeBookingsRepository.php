<?php

namespace App\Repository;

use App\Entity\ImmigrationOfficeBookings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImmigrationOfficeBookings>
 *
 * @method ImmigrationOfficeBookings|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImmigrationOfficeBookings|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImmigrationOfficeBookings[]    findAll()
 * @method ImmigrationOfficeBookings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImmigrationOfficeBookingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImmigrationOfficeBookings::class);
    }

    public function add(ImmigrationOfficeBookings $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ImmigrationOfficeBookings $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ImmigrationOfficeBookings[] Returns an array of ImmigrationOfficeBookings objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ImmigrationOfficeBookings
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
