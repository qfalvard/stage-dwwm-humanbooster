<?php

namespace App\Repository;

use App\Entity\EvaluerStage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EvaluerStage|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvaluerStage|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvaluerStage[]    findAll()
 * @method EvaluerStage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluerStageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvaluerStage::class);
    }

  
}
