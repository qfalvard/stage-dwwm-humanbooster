<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function findAllStagiaires($id): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT utilisateur.prenom, utilisateur.nom
        FROM utilisateur
        JOIN participer ON participer.stagiaire_id = utilisateur.id
        JOIN session ON session.id = participer.session_id
        WHERE session.id = :id
        ORDER BY utilisateur.prenom ASC;
        ';
        $statement = $connection->prepare($sql);
        $statement->execute(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $statement->fetchAll();
    }

    public function findAllEncadrants($id): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT utilisateur.prenom, utilisateur.nom
        FROM utilisateur
        JOIN encadrer ON encadrer.encadrant_id = utilisateur.id
        JOIN session ON session.id = encadrer.session_id
        WHERE session.id = :id
        ORDER BY utilisateur.prenom ASC;
        ';
        $statement = $connection->prepare($sql);
        $statement->execute(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $statement->fetchAll();
    }

    public function findFormateurTre($id): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT utilisateur.prenom, utilisateur.nom
        FROM utilisateur
        JOIN former ON former.formateur_id = utilisateur.id
        JOIN session ON session.id = former.session_id
        JOIN module ON module.id = former.module_id 
        WHERE session.id = :id AND module.is_tre = 1;
        ';
        $statement = $connection->prepare($sql);
        $statement->execute(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $statement->fetchAll();
    }

    // public function findAllFormateurs(): array
    // {
    //     $connection = $this->getEntityManager($id)->getConnection();

    //     $sql = '
    //     SELECT utilisateur.prenom, utilisateur.nom
    //     FROM utilisateur
    //     JOIN former ON former.formateur_id = utilisateur.id
    //     JOIN session ON session.id = former.session_id
    //     WHERE session.id = :id
    //     ORDER BY utilisateur.prenom ASC;
    //     ';
    //     $statement = $connection->prepare($sql);
    //     $statement->execute(['id' => $id]);

    //     // returns an array of arrays (i.e. a raw data set)
    //     return $statement->fetchAll();
    // }

    public function findAllModules($id): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT module.nom as module
        FROM module
        JOIN competence ON competence.id = module.competence_id
        JOIN ccp ON ccp.id = competence.ccp_id
        JOIN titre_professionnel ON titre_professionnel.id = ccp.titre_professionnel_id
        JOIN session ON session.titre_professionnel_id = titre_professionnel.id
        WHERE session.id = :id;
        ';
        $statement = $connection->prepare($sql);
        $statement->execute(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $statement->fetchAll();
    }

    public function findAllModulesandFormateurs($id): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT utilisateur.prenom, utilisateur.nom, module.nom AS module
        FROM utilisateur
        JOIN former ON former.formateur_id = utilisateur.id
        JOIN module ON former.module_id = module.id
        WHERE former.session_id = :id AND former.module_id IN (SELECT module.id
        FROM module
        JOIN competence ON competence.id = module.competence_id
        JOIN ccp ON ccp.id = competence.ccp_id
        JOIN titre_professionnel ON titre_professionnel.id = ccp.titre_professionnel_id
        JOIN session ON session.titre_professionnel_id = titre_professionnel.id
        WHERE session.id = :id
        )
        ';
        $statement = $connection->prepare($sql);
        $statement->execute(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $statement->fetchAll();
    }





    // /**
    //  * @return Session[] Returns an array of Session objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Session
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */





}
