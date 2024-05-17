<?php

namespace App\Repository;

use App\Entity\EmployeeCalendarSetUp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmployeeCalendarSetUp>
 *
 * @method EmployeeCalendarSetUp|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeCalendarSetUp|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeCalendarSetUp[]    findAll()
 * @method EmployeeCalendarSetUp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeCalendarSetUpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeCalendarSetUp::class);
    }

    public function add(EmployeeCalendarSetUp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EmployeeCalendarSetUp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EmployeeCalendarSetUp[] Returns an array of EmployeeCalendarSetUp objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EmployeeCalendarSetUp
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
