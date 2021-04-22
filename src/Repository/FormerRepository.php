<?php

namespace App\Repository;

use App\Entity\Former;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Former|null find($id, $lockMode = null, $lockVersion = null)
 * @method Former|null findOneBy(array $criteria, array $orderBy = null)
 * @method Former[]    findAll()
 * @method Former[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Former::class);
    }

    // /**
    //  * @return Former[] Returns an array of Former objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Former
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
