<?php

namespace App\Controller;

use App\Entity\RechercheStage;
use App\Entity\Utilisateur;
use App\Entity\Session;
use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\RechercheStageRepository;
use App\Form\RechercheStageType;
use App\Form\RechercheStageCommentaireHBType;
use App\Form\RechercheStageCommentaireTREType;
use App\Form\ContactStageType;
use App\Repository\FormerRepository;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/stage")
 */
class StageController extends AbstractController
{
    /**
    * @Route("/recapitulatif_des_stages", name="recapitulatif_des_stages") 
    */
    public function recapStages(RechercheStageRepository $rechercheStageRepository)
    {
        return $this->render('stage/index.html.twig', [
            'recapStages' => $rechercheStageRepository->findAll(),
        ]);
    }
}
