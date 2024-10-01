<?php

namespace App\Repository;

use App\Entity\Opinion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Opinion>
 *
 * @method Opinion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Opinion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Opinion[]    findAll()
 * @method Opinion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpinionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Opinion::class);
    }

    /**
     * Find all entities where isAuthorised is true.
     */
    public function findAllAuthorised()
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.isAuthorized = :isAuthorized')
            ->setParameter('isAuthorized', true)
            ->getQuery()
            ->getResult();
    }

    public function findLatestTwoAuthorised()
    {
        return $this->findBy(
            ['isAuthorized' => true],
            ['updated_at' => 'DESC'],
            2
        );
    }
}
