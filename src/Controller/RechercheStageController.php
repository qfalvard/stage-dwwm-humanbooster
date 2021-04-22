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
 * @Route("/recherche_stage")
 */
class RechercheStageController extends AbstractController
{
    /**
     * @Route("/session/{session_id}", name="recherche_stage_index", methods={"GET"})
     *
     * 
     */
    public function index( $session_id,Request $request, FormerRepository $formerRepository, RechercheStageRepository $rechercheStageRepository, EntrepriseRepository $entrepriseRepository, UtilisateurRepository $utilisateurRepository, SessionRepository $sessionRepository): Response
    {
        $date = $request->query->get('date');
        if (TRUE === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || TRUE === $this->get('security.authorization_checker')->isGranted('ROLE_FORMATEUR') || TRUE === $this->get('security.authorization_checker')->isGranted('ROLE_FORMATEUR_TRE')) {

            $stagiaire_id = $request->query->get('stagiaire_id');
            $entreprise_id = $request->query->get('entreprise_id');
         
            $user = $utilisateurRepository->findOneBy(['id' => $stagiaire_id]);

            $entreprise = $entrepriseRepository->findOneBy(['id' => $entreprise_id]);
            
            $rechercheStageEntreprise = $rechercheStageRepository->findAllRechercheStageParEntreprisePourUnStagiaire($stagiaire_id);
                return $this->render('recherche_stage/index.html.twig', [
                
                    'recherche_stages' => $rechercheStageRepository->findAll(),
                    'entreprises' => $entrepriseRepository->findAll(),
                    'users' => $utilisateurRepository->findAll(),
                    'former' => $formerRepository->findAll(),
                    'session' => $sessionRepository->findAll(),
                    'session_id' => $session_id,
                    'stagiaire_id' => $stagiaire_id,
                    'entreprise_id' => $entreprise_id,
                    'user' => $user,
                    'entreprise' => $entreprise,
                    'rechercheStageEntreprise' => $rechercheStageEntreprise,
                    'date' => $date,
                ]);
        }
            $utilisateur_courant = $this->getUser()->getId();
            $entreprise_id = $request->query->get('entreprise_id');
            $entrepriseRepository = $this->getDoctrine()->getRepository(Entreprise::class);
            $entreprise = $entrepriseRepository->findOneBy(['id' => $entreprise_id]);
            $rechercheStageEntreprise2 = $rechercheStageRepository->findAllRechercheStageParEntreprisePourleStagiaireConnecter($utilisateur_courant);

            return $this->render('recherche_stage/indexStagiaire.html.twig' ,[
            'recherche_stages' => $rechercheStageRepository->findAll(),
            'entreprises' => $entrepriseRepository->findAll(),
            'users' => $utilisateurRepository->findAll(),
            'former' => $formerRepository->findAll(),
            'session' => $sessionRepository->findAll(),
            'entreprise_id' => $entreprise_id,
            'session_id' => $session_id,
            'rechercheStageEntreprise2' => $rechercheStageEntreprise2,
            'date' => $date,
            'entreprise' => $entreprise,
            ]);
        }
    

    /**
     * @Route("/ajouter/{user_id}/session/{session_id}", name="recherche_stage_new", methods={"GET","POST"})
     */
    public function new($session_id, $user_id, Request $request): Response
    {

        $utilisateurRepository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $user = $utilisateurRepository->findOneBy(['id' => $user_id]);
        $rechercheStage = new RechercheStage();
        $form = $this->createForm(RechercheStageType::class, $rechercheStage);
        $form->handleRequest($request);
        


        if (($form->isSubmitted() && $form->isValid()) ) {
            
        
            $entityManager = $this->getDoctrine()->getManager();

            $rechercheStage->setUtilisateur($user);

            $entityManager->persist($rechercheStage);
            $entityManager->flush();

            $this->addFlash('success', 'La nouvelle recherche de stage à bien été ajouté');
            return $this->redirectToRoute('recherche_stage_index', [
                'session_id' => $session_id,
            ]);
        }

        return $this->render('recherche_stage/new.html.twig', [
            'recherche_stages' => $rechercheStage,
            'form' => $form->createView(),
            'session_id' => $session_id,    

        ]);
    }
    /**
     * @Route("/{id}/editer/session/{session_id}", name="recherche_stage_edit", methods={"GET","POST"})
     */
    public function edit($session_id,  Request $request, RechercheStage $rechercheStage): Response
    {
        
        $form = $this->createForm(RechercheStageType::class, $rechercheStage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'La modification de la recherche de stage à bien été effectuer');
            return $this->redirectToRoute('recherche_stage_index', [
                'session_id' => $session_id
            ]);
        }

        return $this->render('recherche_stage/edit.html.twig', [
            'recherche_stage' => $rechercheStage,
            'form' => $form->createView(),
            'session_id' => $session_id
        ]);
    }

    /**
     * @Route("/{id}/commentaireHB/session/{session_id}/stagiaire/{stagiaire_id}", name="recherche_stage_commentaireHB", methods={"GET","POST"})
     */
    public function commentaireHB($session_id ,$stagiaire_id, Request $request, RechercheStage $rechercheStage): Response
    {
    
        $form = $this->createForm(RechercheStageCommentaireHBType::class, $rechercheStage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recherche_stage_index', [
                'session_id' => $session_id,
                'stagiaire_id' => $stagiaire_id,
            ]);
        }

        return $this->render('recherche_stage/ajoutCommentaire.html.twig', [
            'recherche_stage' => $rechercheStage,
            'form' => $form->createView(),
            'session_id' => $session_id,
            'stagiaire_id' => $stagiaire_id,
        ]);
    }


    /**
     * @Route("/{id}/commentaireTRE/session/{session_id}", name="recherche_stage_commentaireTRE", methods={"GET","POST"})
     */
    public function commentaireTRE($session_id, Request $request, RechercheStage $rechercheStage): Response
    {
        
        $form = $this->createForm(RechercheStageCommentaireTREType::class, $rechercheStage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recherche_stage_index', [
                'session_id' => $session_id
            ]);
        }

        return $this->render('recherche_stage/ajoutCommentaire.html.twig', [
            'recherche_stage' => $rechercheStage,
            'form' => $form->createView(),
            'session_id' => $session_id,
        ]);
    }

    /**
     * 
     * @Route("/contactStage/ajouter/session/{session_id}", name="contact_new" , methods={"GET","POST"})
     */
    public function registercontact($session_id, Request $request): Response
    {
        
        $contact = new Utilisateur();
        $form = $this->createForm(ContactStageType::class, $contact);
        $form->handleRequest($request);
        $password = ""; 
        $roles = [];
        $referer = $request->server->get('HTTP_REFERER');
        if ($form->isSubmitted() && $form->isValid()) {

                $contact->setPassword($password);
                $contact->setRoles($roles);
                $contact->setIsActif(0);
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($contact);
                $entityManager->flush();
                $this->addFlash('success', 'Le nouveau contact à bien été créer');
                return $this->redirectToRoute('recherche_stage_index', [
                    'session_id' => $session_id
                ]);
        }
      
        return $this->render('recherche_stage/new.html.twig', [
            'form' => $form->createView(),
            'session_id' => $session_id
        ]);
    }

     /**
     * @Route("/recherche_stage/{id}/session/{session_id}/supprimer", name="recherche_stage_delete", methods={"DELETE"})
     */
    public function delete($session_id, Request $request, RechercheStage $rechercheStage): Response
    {
        
        if ($this->isCsrfTokenValid('delete'.$rechercheStage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rechercheStage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recherche_stage_index', [
            'session_id' => $session_id,
        ]);
    }

}