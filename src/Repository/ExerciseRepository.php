<?php

namespace App\Repository;

use App\Entity\Exercise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exercise>
 */
class ExerciseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercise::class);
    }

    //    /**
    //     * @return ExerciseController[] Returns an array of ExerciseController objects
    //     */
     public function findByExampleField($value): array
       {
           return $this->createQueryBuilder('e')
               ->andWhere('e.exampleField = :val')
               ->setParameter('val', $value)
               ->orderBy('e.id', 'ASC')
                ->setMaxResults(10)
              ->getQuery()
               ->getResult();
       }

    //    public function findOneBySomeField($value): ?ExerciseController
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
