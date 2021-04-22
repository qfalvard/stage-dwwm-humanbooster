<?php

namespace App\Repository;

use App\Entity\Encadrer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Encadrer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Encadrer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Encadrer[]    findAll()
 * @method Encadrer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EncadrerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Encadrer::class);
    }

    // /**
    //  * @return Encadrer[] Returns an array of Encadrer objects
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
    public function findOneBySomeField($value): ?Encadrer
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
