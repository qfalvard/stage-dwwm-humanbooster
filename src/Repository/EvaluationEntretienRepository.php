<?php

namespace App\Repository;

use App\Entity\EvaluationEntretien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EvaluationEntretien|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvaluationEntretien|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvaluationEntretien[]    findAll()
 * @method EvaluationEntretien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluationEntretienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvaluationEntretien::class);
    }

  
}
