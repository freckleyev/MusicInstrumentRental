<?php

namespace App\Repository;

use App\Entity\Instruments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Instruments>
 */
class InstrumentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Instruments::class);
    }

    /**
     * Find instruments for the homepage.
     *
     * @return Instruments[]
     */
    public function findForGuest(
        ?string $search,
        ?string $categoryId
    ): array {
        $queryBuilder = $this->createQueryBuilder('i')
            ->leftJoin('i.category', 'c')
            ->addSelect('c')
            ->orderBy('i.name', 'ASC');

        // Search by instrument name or category
        if ($search) {
            $queryBuilder
                ->andWhere(
                    'LOWER(i.name) LIKE LOWER(:search)
                    OR LOWER(c.name) LIKE LOWER(:search)'
                )
                ->setParameter('search', '%' . $search . '%');
        }

        // Filter by category
        if ($categoryId) {
            $queryBuilder
                ->andWhere('c.id = :category')
                ->setParameter('category', $categoryId);
        }

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }
}