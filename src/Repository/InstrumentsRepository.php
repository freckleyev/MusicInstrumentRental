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
     * Find active instruments for the guest homepage.
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
            ->andWhere('i.is_active = :active')
            ->setParameter('active', true)
            ->orderBy('i.name', 'ASC');

        // Search by instrument name or category name
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