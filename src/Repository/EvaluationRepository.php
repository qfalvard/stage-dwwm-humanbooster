<?php

namespace App\Repository;

use App\Entity\Evaluation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evaluation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evaluation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evaluation[]    findAll()
 * @method Evaluation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evaluation::class);
    }
    /**
     * SELECT * FROM `evaluation`
     * INNER JOIN utilisateur ON evaluation.utilisateur = utilisateur.id
     * WHERE utilisateur.role = 'stagiaire'
     */
     /**
     * SELECT * FROM `comment`
     * INNER JOIN user ON comment.user_id = user.id
     * WHERE user.username = 'bob'
    
    *public function getByUsername($username)
   * {
    *    return $this->createQueryBuilder('e')
    *        ->join('e.utilisateur', 'u')
    *        ->where('u.role = :nom')
    *        ->setParameter(':username', $nom)
     *       ->getQuery()
    *        ->getResult();
    *}
 */
    // /**
    //  * @return Evaluation[] Returns an array of Evaluation objects
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
    public function findOneBySomeField($value): ?Evaluation
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
