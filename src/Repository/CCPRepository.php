<?php

namespace App\Repository;

use App\Entity\CCP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CCP|null find($id, $lockMode = null, $lockVersion = null)
 * @method CCP|null findOneBy(array $criteria, array $orderBy = null)
 * @method CCP[]    findAll()
 * @method CCP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CCPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CCP::class);
    }

    // /**
    //  * @return CCP[] Returns an array of CCP objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CCP
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
