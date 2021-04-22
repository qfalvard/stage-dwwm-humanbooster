<?php

namespace App\Repository;

use App\Entity\EnCours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnCours|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnCours|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnCours[]    findAll()
 * @method EnCours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnCoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnCours::class);
    }

    // /**
    //  * @return EnCours[] Returns an array of EnCours objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EnCours
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
