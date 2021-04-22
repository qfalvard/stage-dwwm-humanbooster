<?php

namespace App\Repository;

use App\Entity\Comprendre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comprendre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comprendre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comprendre[]    findAll()
 * @method Comprendre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComprendreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comprendre::class);
    }

  
}
