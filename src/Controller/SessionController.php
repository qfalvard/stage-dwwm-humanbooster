<?php

namespace App\Controller;

use App\Entity\Encadrer;
use App\Entity\Former;
use App\Entity\Session;
use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Form\SessionType;
use App\Repository\EncadrerRepository;
use App\Repository\FormerRepository;
use App\Repository\ModuleRepository;
use App\Repository\SessionRepository;
use App\Repository\UtilisateurRepository;
use DateInterval;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/session")
 */
class SessionController extends AbstractController
{

    private $participants;

    public function __construct(SessionRepository $sessionRepository)
    {
        $sessions = $sessionRepository->findAll();
        $this->participants = [];

        foreach ($sessions as $session) {
            $stagiaires = $session->getStagiaires();
            $encadrers = $session->getEncadrers();
            $formers = $session->getFormers();

            foreach ($stagiaires as $stagiaire) {
                array_push($this->participants, $stagiaire);
            }
            foreach ($encadrers as $encadrer) {
                array_push($this->participants, $encadrer->getEncadrant());
            }
            foreach ($formers as $former) {
                array_push($this->participants, $former->getFormateur());
            }
        }
        return $this->participants;
    }


    /**
     * @Route("/", name="session_index", methods={"GET"})
     */
    public function index(SessionRepository $sessionRepository): Response
    {
        
        return $this->render('session/index.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/ajouter", name="session_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);
        $dateNow = new \DateTime('now');
        $dateDebut = $session->getDateDebut($form->get('dateDebut'));
        
        $dateFin = $session->getDateFin($form->get('dateFin'));

        $dateExpire = new \DateTime(date_format($dateFin, 'Y-m-d'));
        $dateExpire->modify('+ 4 months');
        // $dateExpire->add(new DateInterval('P4M'));

        
        if ($form->isSubmitted() && $form->isValid()) {
            if ($dateNow >= $dateDebut && $dateNow < $dateExpire) {
                // Alors on passe son statut sur actif dans la base de donnée
                $session->setIsActif(true);
            } else {
                $session->setIsActif(false);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('session_index');
        }

        return $this->render('session/new.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="session_show", methods={"GET","POST"})
     */
    public function show(UserInterface $user,Session $session, FormerRepository $formerRepository, EncadrerRepository $encadrerRepository, UtilisateurRepository $utilisateurRepository): Response
    {

        $formers = $formerRepository->findAll();
        $encadrers = $encadrerRepository->findAll();
        $stagiaires = $utilisateurRepository->findByRole("ROLE_STAGIAIRE");
        $formateurs = $utilisateurRepository->findByRole("ROLE_FORMATEUR");
        $encadrants = $utilisateurRepository->findByRole("ROLE_ENCADRANT");
        $stagiairesSession = $session->getStagiaires();
        $encadrersSession = $session->getEncadrers();
        $formersSession = $session->getFormers();
        $participantsSession = [];

        foreach ($stagiairesSession as $stagiaire) {
            array_push($participantsSession, $stagiaire);
        }
        foreach ($encadrersSession as $encadrer) {
            array_push($participantsSession, $encadrer->getEncadrant());
        }
        foreach ($formersSession as $former) {
            array_push($participantsSession, $former->getFormateur());
        }

        if (in_array($user, $participantsSession) || in_array($user, $encadrants)) {
            $titres = $session->getTitreProfessionnel();
            $modules = [];
            foreach ($titres->getCcp() as $ccps) {
                foreach ($ccps->getCompetence() as $competences) {
                    foreach ($competences->getModule() as $module) {
                        array_push($modules, ++$module);
                    }
                }
            }

            return $this->render('session/show.html.twig', [
                'session' => $session,
                'modules' => $modules,
                'formers' => $formers,
                'encadrers' => $encadrers,
                'stagiaires' => $stagiaires,
                'formateurs' => $formateurs,
                'encadrants' => $encadrants
            ]);
        } else {
            return $this->redirectToRoute('accessDenied');
        }
    }

    /**
     * @Route("/{id}/editer", name="session_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Session $session): Response
    {
        $dateNow = new \DateTime('now');
        $dateDebut = $session->getDateDebut();
        $dateFin = $session->getDateFin();
        $dateExpire = new \DateTime(date_format($dateFin, 'Y-m-d'));
        $dateExpire->modify('+ 4 months');
        // $dateExpire->add(new DateInterval('P4M'));
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($dateNow >= $dateDebut && $dateNow < $dateExpire) {
                // Alors on passe son statut sur actif dans la base de donnée
                $session->setIsActif(true);
            } else {
                $session->setIsActif(false);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('session_index');
        }
        if ($dateNow >= $dateExpire) {

            // Alors on passe son statut sur inactif dans la base de donnée
            $session->setIsActif(false);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('session_index');
        }

        return $this->render('session/edit.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="session_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Session $session): Response
    {
        if ($this->isCsrfTokenValid('delete' . $session->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($session);
            $entityManager->flush();
        }

        return $this->redirectToRoute('session_index');
    }

    /**
     * @Route("/{id}/ajout_stagiaire", name="session_ajout_stagiaire", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function ajoutStagiaire(Request $request, UtilisateurRepository $utilisateurRepository, Session $session): Response
    {
        // On utilise le repository pour trouver tous les stagiaires potentiels en BDD
        $stagiaires = $utilisateurRepository->findByRole("ROLE_STAGIAIRE");

        // On récupère tous mes stagiaires déjà inscrits sur cette formation
        $stagiairesBDD = $session->getStagiaires();
        $StagiairesInscrits = [];
        foreach ($stagiairesBDD as $stagiaireInscrit) {
            array_push($StagiairesInscrits, $stagiaireInscrit);
        }

        // On compte le nombre de stagiaire dans la session pour le comparer à la fin de la fonction
        $compteurDebut = 0;
        foreach ($stagiairesBDD as $nombreInscrit) {
            $compteurDebut++;
        }

        // Par sécurité, on vérifie que la requête est bien passée en requète post.
        if ($request->isMethod(('POST'))) {

            // On créer un compteur qui nous servira à connaitre le nombre de nouveaux inscrit lors de la validation

            // Boucle de 1 à 10 permettant de chercher une correspondance entre l'id à l'index i et l'id des stagiaires
            // A chaque itération de la boucle, on vérifie l'input "stagiaire+i" ("stagiaire1, stagiaire2, etc)
            // On ajoute chaque correspondance à la session.
            for ($i = 1; $i <= 10; $i++) {

                // On récupère le stagiaire sélectionner dans le select "stagiaire.$i"
                $stagiaireSelect =  $utilisateurRepository->findOneBy(["id" => $request->get("stagiaire" . $i)]);
                // dump($stagiaireSelect);

                // On vérifie si le select est remplie.
                if (isset($stagiaireSelect)) {
                    // Si il l'est, alors on vérifie si il y a déjà des stagiaires dans cette session.
                    // Si il n'y a pas de stagiaire, alors isset($stagiairesBDD) = true. Donc :
                    if (isset($StagiairesInscrits)) {
                        if (in_array($stagiaireSelect, $StagiairesInscrits)) {
                            $this->addFlash('warning', 'L\'utilisateur ' . $stagiaireInscrit->getNom() . ' est déjà inscrit à cette session.');
                        } else {
                            $session->addStagiaire($stagiaireSelect);
                        }
                    } else { // Si la session est vide alors on ajoute directement le nouveau stagiaire.
                        dump(6);
                        $session->addStagiaire($stagiaireSelect);
                    }
                }
            }
            // On utilise Doctrine pour enregistrer le contenu de session en BDD
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($session);
            $entityManager->flush();

            // On créer un nouveau compteur pour connaitre le nombre de nouveaux inscrits
            $compteurFin = 0;
            foreach ($stagiairesBDD as $nombreInscrit) {
                $compteurFin++;
            }
            $compteurFin = $compteurFin - $compteurDebut;

            // Envoie d'un message de succès avec le nombre de nouveaux inscrits
            if ($compteurFin > 1) {
                $this->addFlash('success', $compteurFin . " nouveaux stagiaires ont été ajoutés");
            } else {
                $this->addFlash('success', $compteurFin . " nouveau stagiaire a été ajouté");
            }

            return $this->redirectToRoute('session_show', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('session/ajout_stagiaire.html.twig', [
            'session' => $session,
            "stagiaires" => $stagiaires,
        ]);
    }

    /**
     * @Route("/{session}/delete/stagiaire/{stagiaire}", name="stagiaire_delete", methods={"DELETE"}, requirements={"session"="\d+", "stagiaire"="\d+"})
     */
    public function supprimerStagiaire(Request $request, Session $session, Utilisateur $stagiaire): Response
    {
        if (isset($request)) {
            // $session->removeStagiaire($stagiaire);
            if ($this->isCsrfTokenValid('delete' . $session->getId(), $request->request->get('_token'))) {
                $session->removeStagiaire($stagiaire);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($session);
                $entityManager->flush();
            }
        }
        // dd($stagiaire);

        $this->addFlash('success', 'Le stagiaire ' . $stagiaire->getPrenom() . ' ' . strtoupper($stagiaire->getNom()) . ' a été supprimé');

        return $this->redirectToRoute('session_show', ['id' => $session->getId()]);
    }

    /**
     * @Route("/{id}/ajout_formateur", name="session_ajout_formateur", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function ajoutFormateur(Request $request, UtilisateurRepository $utilisateurRepository, Session $session, FormerRepository $formerRepository): Response
    {
        // On cherche tous les utilisateurs enregistrés pour les renvoyer dans les selects de la vue
        $formateurs = $utilisateurRepository->findByRole("ROLE_FORMATEUR");

        // On cherche toutes les associations de formation (formateur/module/session)
        $formers = $formerRepository->findBy(['session' => $session]);

        // On récupère le titre pro associé à la session
        $titres = $session->getTitreProfessionnel();

        // On créer un tableau qui regroupera tous les modules du titre pro. On les récupère aussi dans la vue
        $modules = [];

        // et on remonte toute les entités liées jusqu'à obtenir la liste de modules
        foreach ($titres->getCcp() as $ccps) {
            foreach ($ccps->getCompetence() as $competences) {
                foreach ($competences->getModule() as $module) {
                    // qu'on ajoute au tableau modules
                    array_push($modules, ++$module);
                }
            }
        }

        // On vérifie qu'une requête POST nous parvient du formulaire. Sinon on retourne le formulaire.
        if ($request->isMethod(('POST'))) {

            // Pour chaque module du tableau ( donc de la session)
            foreach ($modules as $module) {

                // On récupère le formateur choisi dans le select.
                // Pour le différencier des autres, on a concaténé l'id du module dont il aura la charge
                $formateur = $utilisateurRepository->findOneBy(["id" => $request->get('formateur' . $module->getId())]);

                // dump($formateur);
                if (isset($formateur)) {
                    $former = new Former();
                    $former->setSession($session);
                    $former->setModule($module);
                    $former->setFormateur($formateur);
                    $former->setDateFin(new \DateTime($request->get('datetime' . $module->getId())));

                    // On utilise doctrine pour les insérer dans la BBD
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($former);
                    $entityManager->flush();




                    // if (isset($formers)) {
                    //     $former = new Former();
                    //     $former->setSession($session);
                    //     $former->setModule($module);
                    //     $former->setFormateur($formateur);
                    //     $former->setDateFin(new \DateTime($request->get('datetime' . $module->getId())));

                    //     // On utilise doctrine pour les insérer dans la BBD
                    //     $entityManager = $this->getDoctrine()->getManager();
                    //     $entityManager->persist($former);
                    //     $entityManager->flush();
                    // } else {
                    //     foreach ($formers as $former) {
                    //         // dd($formateur->getId(), $former->getFormateur()->getId());
                    //         if ($formateur->getId() != $former->getFormateur()->getId()) {
                    //             // On crée une nouvelle association de formation et lui rentre les paramètres insérés dans la request
                    //             $former = new Former();
                    //             $former->setSession($session);
                    //             $former->setModule($module);
                    //             $former->setFormateur($formateur);
                    //             $former->setDateFin(new \DateTime($request->get('datetime' . $module->getId())));

                    //             // On utilise doctrine pour les insérer dans la BBD
                    //             $entityManager = $this->getDoctrine()->getManager();
                    //             $entityManager->persist($former);
                    //             $entityManager->flush();
                    //         }
                    //     }
                    // }
                }
            }
            // die;
            // on retourne un message de validation
            $this->addFlash('success', 'Le(s) formateur(s) ont été ajoutés');
            // et on retourne sur la vue de la session
            return $this->redirectToRoute('session_show', ['id' => $session->getId()]);
        }

        return $this->render('session/ajout_formateur.html.twig', [
            'formateurs' => $formateurs,
            'modules' => $modules
        ]);
    }

    /**
     * @Route("/{session}/editer_formateur/{former}", name="session_editer_formateur", methods={"GET","POST"}, requirements={"session"="\d+", "former"="\d+"})
     */
    public function editerFormateur(Request $request, Session $session, Former $former, UtilisateurRepository $utilisateurRepository): Response
    {
        $formateurs = $utilisateurRepository->findByRole("ROLE_FORMATEUR");

        $formateur = $utilisateurRepository->findOneBy(["id" => $request->get('formateur')]);
        // On vérifie qu'une requête POST nous parvient du formulaire. Sinon on retourne le formulaire.
        if ($request->isMethod(('POST'))) {
            $former->setFormateur($formateur);
            $former->setDateFin(new \DateTime($request->get('datetime')));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($former);
            $entityManager->flush();

            $this->addFlash('success', 'Le formateur ' . $formateur->getPrenom() . ' ' . strtoupper($formateur->getNom()) . ' a été modifié');

            return $this->redirectToRoute('session_show', ['id' => $session->getId()]);
        }

        return $this->render('session/editer_formateur.html.twig', [
            'formateurs' => $formateurs,
            // 'session' => $session,
            'former' => $former
        ]);
    }

    /**
     * @Route("/{session}/delete_formateur/{former}", name="formateur_delete", methods={"DELETE"}, requirements={"session"="\d+", "former"="\d+"})
     */
    public function supprimerFormateur(Request $request, Session $session, Former $former): Response
    {
        // $session->removeStagiaire($stagiaire);

        $formateur = $former->getFormateur();
        if ($this->isCsrfTokenValid('delete' . $former->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($former);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Le formateur ' . $formateur->getPrenom() . ' ' . strtoupper($formateur->getNom()) . ' a été supprimé');

        return $this->redirectToRoute('session_show', ['id' => $session->getId()]);
    }

    /**
     * @Route("/{id}/ajout_encadrant", name="session_ajout_encadrant", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function ajoutEncadrant(Request $request, Session $session, UtilisateurRepository $utilisateurRepository, EncadrerRepository $encadrerRepository)
    {
        $encadrants = $utilisateurRepository->findByRole("ROLE_ENCADRANT");

        if ($request->isMethod('POST')) {
            for ($i = 1; $i <= 3; $i++) {
                $encadrant =  $utilisateurRepository->findOneBy(["id" => $request->get("encadrant" . $i)]);
                if (isset($encadrant)) {
                    $ordre = $request->get('ordre' . $i);

                    $encadrer = new Encadrer();
                    $encadrer->setSession($session);
                    $encadrer->setEncadrant($encadrant);
                    $encadrer->setOrdre($ordre);

                    // On utilise doctrine pour les insérer dans la BBD
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($encadrer);
                    $entityManager->flush();
                }
            }

            $this->addFlash('success', 'Le(s) encadrant(s) ont été ajouté(s)');

            return $this->redirectToRoute('session_show', ['id' => $session->getId()]);
        }

        return $this->render('session/ajout_encadrant.html.twig', [
            'encadrants' => $encadrants,
            'session' => $session
        ]);
    }

    /**
     * @Route("/{session}/delete_encadrant/{encadrer}", name="encadrant_delete", methods={"DELETE"}, requirements={"session"="\d+", "encadrer"="\d+"})
     */
    public function supprimerEncadrant(Request $request, Session $session, Encadrer $encadrer): Response
    {
        // $session->removeStagiaire($stagiaire);
        $encadrant = $encadrer->getEncadrant();
        // dd($encadrant);
        if ($this->isCsrfTokenValid('delete' . $session->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($encadrer);
            $entityManager->flush();
        }

        $this->addFlash('success', 'L\'encadrant ' . $encadrant->getPrenom() . ' ' . strtoupper($encadrant->getNom()) . ' a été supprimé');

        return $this->redirectToRoute('session_show', ['id' => $session->getId()]);
    }
}
