<?php

namespace App\Repository;

use App\Entity\CritereEvaluationStage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CritereEvaluationStage|null find($id, $lockMode = null, $lockVersion = null)
 * @method CritereEvaluationStage|null findOneBy(array $criteria, array $orderBy = null)
 * @method CritereEvaluationStage[]    findAll()
 * @method CritereEvaluationStage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CritereEvaluationStageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CritereEvaluationStage::class);
    }

  
}
