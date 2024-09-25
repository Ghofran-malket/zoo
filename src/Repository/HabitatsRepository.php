<?php

namespace App\Repository;

use App\Entity\Habitats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Habitats>
 *
 * @method Habitats|null find($id, $lockMode = null, $lockVersion = null)
 * @method Habitats|null findOneBy(array $criteria, array $orderBy = null)
 * @method Habitats[]    findAll()
 * @method Habitats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HabitatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Habitats::class);
    }

//    /**
//     * @return Habitats[] Returns an array of Habitats objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Habitats
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
