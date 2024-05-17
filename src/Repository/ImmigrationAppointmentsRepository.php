<?php

namespace App\Repository;

use App\Entity\ImmigrationAppointments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImmigrationAppointments>
 *
 * @method ImmigrationAppointments|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImmigrationAppointments|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImmigrationAppointments[]    findAll()
 * @method ImmigrationAppointments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImmigrationAppointmentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImmigrationAppointments::class);
    }

    public function add(ImmigrationAppointments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ImmigrationAppointments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ImmigrationAppointments[] Returns an array of ImmigrationAppointments objects
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

//    public function findOneBySomeField($value): ?ImmigrationAppointments
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
