<?php

namespace App\Repository;

use App\Entity\RechercheStage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RechercheStage|null find($id, $lockMode = null, $lockVersion = null)
 * @method RechercheStage|null findOneBy(array $criteria, array $orderBy = null)
 * @method RechercheStage[]    findAll()
 * @method RechercheStage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RechercheStageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RechercheStage::class);
    }
    public function findAllRechercheStageParEntreprisePourUnStagiaire($stagiaire_id): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT recherche_stage.entreprise_id, entreprise.nom,
        COUNT(recherche_stage.entreprise_id) as NB
        FROM recherche_stage
        LEFT JOIN entreprise ON recherche_stage.entreprise_id = entreprise.id
        WHERE recherche_stage.utilisateur_id = :stagiaire_id
        GROUP BY recherche_stage.entreprise_id;
        ';
        $statement = $connection->prepare($sql);
        $statement->execute(['stagiaire_id' => $stagiaire_id]);

        // returns an array of arrays (i.e. a raw data set)
        return $statement->fetchAll();

    }

    public function findAllRechercheStageParEntreprisePourleStagiaireConnecter($utilisateur_courant): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT recherche_stage.entreprise_id, entreprise.nom,
        COUNT(recherche_stage.entreprise_id) as NB
        FROM recherche_stage
        LEFT JOIN entreprise ON recherche_stage.entreprise_id = entreprise.id
        WHERE recherche_stage.utilisateur_id = :utilisateur_courant
        GROUP BY recherche_stage.entreprise_id;
        ';
        $statement = $connection->prepare($sql);
        $statement->execute(['utilisateur_courant' => $utilisateur_courant]);

        // returns an array of arrays (i.e. a raw data set)
        return $statement->fetchAll();

    }
 
}
