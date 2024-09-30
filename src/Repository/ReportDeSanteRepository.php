<?php

namespace App\Repository;

use App\Entity\ReportDeSante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReportDeSante>
 *
 * @method ReportDeSante|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportDeSante|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportDeSante[]    findAll()
 * @method ReportDeSante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportDeSanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportDeSante::class);
    }

    public function findLatestReportForAnimal($animalId)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.animal = :animalId')
            ->setParameter('animalId', $animalId)
            ->orderBy('r.created_at', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }


//    /**
//     * @return ReportDeSante[] Returns an array of ReportDeSante objects
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

//    public function findOneBySomeField($value): ?ReportDeSante
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
