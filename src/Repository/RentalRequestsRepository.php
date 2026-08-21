<?php

namespace App\Repository;

use App\Entity\RentalRequests;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RentalRequests>
 */
class RentalRequestsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentalRequests::class);
    }

//    /**
//     * @return RentalRequests[] Returns an array of RentalRequests objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RentalRequests
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function sort(?string $sortBy, ?string $sortDirection): array
    {
        $qb = $this->createQueryBuilder('rr')
            ->leftJoin('rr.user', 'u')->addSelect('u')
            ->leftJoin('rr.instrument', 'i')->addSelect('i');

        // if ($jobTypeId) {
        //     $qb->andWhere('jt.id = :typeId')
        //        ->setParameter('typeId', $jobTypeId);
        // }

        $sortBy = 'rr.' . $sortBy;
        $qb->orderBy($sortBy, $sortDirection);

        return $qb->getQuery()->getResult();
    }
}
