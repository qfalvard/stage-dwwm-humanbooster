<?php

namespace App\Repository;

use App\Entity\CritereEntretien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CritereEntretien|null find($id, $lockMode = null, $lockVersion = null)
 * @method CritereEntretien|null findOneBy(array $criteria, array $orderBy = null)
 * @method CritereEntretien[]    findAll()
 * @method CritereEntretien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CritereEntretienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CritereEntretien::class);
    }
    
}
