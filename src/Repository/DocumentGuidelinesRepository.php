<?php

namespace App\Repository;

use App\Entity\DocumentGuidelines;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DocumentGuidelines>
 *
 * @method DocumentGuidelines|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentGuidelines|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentGuidelines[]    findAll()
 * @method DocumentGuidelines[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentGuidelinesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentGuidelines::class);
    }

    public function add(DocumentGuidelines $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DocumentGuidelines $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DocumentGuidelines[] Returns an array of DocumentGuidelines objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DocumentGuidelines
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
