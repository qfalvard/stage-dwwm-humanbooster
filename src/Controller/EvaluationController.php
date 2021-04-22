<?php

namespace App\Controller;

use App\Entity\Evaluation;
use App\Entity\Module;
use App\Entity\Utilisateur;
use App\Entity\Session;
use App\Form\EvaluationType;
use App\Repository\EvaluationRepository;
use App\Repository\ModuleRepository;
use App\Repository\ObjectifRepository;
use App\Repository\SessionRepository;
use App\Repository\TitreProfessionnelRepository;
use App\Repository\UtilisateurRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/session")
 */
class EvaluationController extends AbstractController
{
    /**
     * @Route("/{session_id}/evaluations/", name="evaluation_index", methods={"GET"})
     */
    public function index(EvaluationRepository $evaluationRepository, $session_id, SessionRepository $sessionRepository, TitreProfessionnelRepository $titreProfessionnelRepository): Response
    {
        $session = $sessionRepository->findOneBy(["id" => $session_id]);
        $titres = $titreProfessionnelRepository->findOneBy(["id" => $session->getTitreProfessionnel()->getId()]);
        $modules = [];
        $objectifs = [];
        foreach ($titres->getCcp() as $ccps) {
            foreach ($ccps->getCompetence() as $competences) {
                foreach ($competences->getModule() as $module) {
                    array_push($modules, $module);
                }
            }
        }
        foreach ($modules as $module) {
            foreach ($module->getObjectif() as $objectif) {
                array_push($objectifs, $objectif);
            }
        }

        return $this->render('evaluation/index.html.twig', [
            'evaluations' => $evaluationRepository->findAll(),
            'modules' => $modules,
            'objectifs' => $objectifs,
            'session' => $session
        ]);
    }

    /**
     * @Route("/{session}/evaluations_indiv/{stagiaire}", name="evaluation_indiv", methods={"GET"}, requirements={"stagiaire"="\d+"})
     */
    public function evalIndiv(Utilisateur $stagiaire, EvaluationRepository $evaluationRepository, Session $session, TitreProfessionnelRepository $titreProfessionnelRepository): Response
    {
        $titre = $titreProfessionnelRepository->findOneBy(["id" => $session->getTitreProfessionnel()->getId()]);

        $ccpstab = [];
        $competencestab = [];
        $modulestab = [];
        $objectifs = [];
        $evaluations = $evaluationRepository->findAll();
        foreach ($titre->getCcp() as $ccps) {
            array_push($ccpstab, $ccps);
            foreach ($ccps->getCompetence() as $competences) {
                array_push($competencestab, $competences);
                foreach ($competences->getModule() as $module) {
                    array_push($modulestab, $module);
                }
            }
        }

        foreach ($modulestab as $module) {
            foreach ($module->getObjectif() as $objectif) {
                array_push($objectifs, $objectif);
            }
        }
        return $this->render('evaluation/eval_indiv.html.twig', [
            'evaluations' => $evaluationRepository->findAll(),
            'ccps' => $ccpstab,
            'competences' => $competencestab,
            'modules' => $modulestab,
            'objectifs' => $objectifs,
            'evaluations' => $evaluations,
            'session' => $session,
            'stagiaire' => $stagiaire
        ]);
    }



    /**
     * @Route("/{session}/evaluations_indiv/{stagiaire}/pdf", name="evaluation_pdf", methods={"GET"}, requirements={"stagiaire"="\d+"})
     */


    public function evalPDF(Request $request, Utilisateur $stagiaire, EvaluationRepository $evaluationRepository, Session $session, TitreProfessionnelRepository $titreProfessionnelRepository): Response
    {

        // $path ='../../logo.jpg';
        // $type = pathinfo($path, PATHINFO_EXTENSION);
        // $data = file_get_contents($path);
        // $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $url = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath() . '/build/img/logo.jpg';


        $titre = $titreProfessionnelRepository->findOneBy(["id" => $session->getTitreProfessionnel()->getId()]);
        $ccpstab = [];
        $competencestab = [];
        $modulestab = [];
        $objectifs = [];
        $evaluations = $evaluationRepository->findAll();
        foreach ($titre->getCcp() as $ccps) {
            array_push($ccpstab, $ccps);
            foreach ($ccps->getCompetence() as $competences) {
                array_push($competencestab, $competences);
                foreach ($competences->getModule() as $module) {
                    array_push($modulestab, $module);
                }
            }
        }

        foreach ($modulestab as $module) {
            foreach ($module->getObjectif() as $objectif) {
                array_push($objectifs, $objectif);
            }
        }

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);
        // $url = $this->generateUrl('evaluation_pdf', ['session' => $session, 'stagiaire' => $stagiaire], UrlGeneratorInterface::ABSOLUTE_URL);

        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('evaluation/eval_pdf.html.twig', [
            'evaluations' => $evaluationRepository->findAll(),
            'ccps' => $ccpstab,
            'competences' => $competencestab,
            'modules' => $modulestab,
            'objectifs' => $objectifs,
            'evaluations' => $evaluations,
            'session' => $session,
            'stagiaire' => $stagiaire,
            'url' => $url,

        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("livret-suivi-acquis.pdf", [
            "Attachment" => true
        ]);

        return $this->render('evaluation/eval_pdf.html.twig', [
            'evaluations' => $evaluationRepository->findAll(),
            'ccps' => $ccpstab,
            'competences' => $competencestab,
            'modules' => $modulestab,
            'objectifs' => $objectifs,
            'evaluations' => $evaluations,
            'session' => $session,
            'stagiaire' => $stagiaire,
            "url" => $url,
        ]);
    }



    /**
     * @Route("/{session}/evaluations/{module}/stagiaire/{utilisateur}", name="evaluation_evaluer", methods={"GET","POST"})
     */
    public function evaluer(Utilisateur $utilisateur, Request $request,Session $session, Module $module, ObjectifRepository $objectifRepository, ModuleRepository $moduleRepository, UtilisateurRepository $utilisateurRepository): Response
    {
        $formateur = $utilisateurRepository->findOneBy(['id' => $request->get('formateur')]);
        // dd($formateur);
        $module = $moduleRepository->findOneBy(["id" => $module]);

        if ($request->isMethod("post")) {
            // on ajoute les évaluations en base de donnée
            for ($i = 0; $i < $request->get('nbObjectifs'); $i++) {
                if ($request->get("aquisition" . $i) != -1 && $request->get("commentaire" . $i) != null 
                    or $request->get("aquisition" . $i) == 15 && $request->get("commentaire" . $i) == null) {
                    $evaluation = new Evaluation();
                    $evaluation->setObjectif($objectifRepository->findOneBy(["id" => $request->get("objectif" . $i)]));
                    $evaluation->setModule($moduleRepository->findOneBy(["id" => $module]));
                    $evaluation->setUtilisateur($utilisateur);
                    $evaluation->setFormateur($formateur);
                    $evaluation->setDate(new DateTime($request->get("date" . $i)));
                    if ($request->get("aquisition" . $i) == 15) {
                        $evaluation->setCommentaire(null);
                    } else {
                        $evaluation->setCommentaire($request->get("commentaire" . $i));
                    }
                    $evaluation->setNiveauAcquisition($request->get("aquisition" . $i));
                    $this->getDoctrine()->getManager()->persist($evaluation);
                }
            }
            $this->getDoctrine()->getManager()->flush();
            // à ce stade là tout c’est bien passé. On envoier l’alerte et redirige vers l’index
            $this->addFlash('success', 'Les évaluations ont bien été ajoutées');
            return $this->redirectToRoute('evaluation_indiv', [
                "session" => $session->getId(),
                'stagiaire' => $utilisateur->getID(),
            ]);
        }
        $this->addFlash('error', 'Il y a eu un problème');
        return $this->redirectToRoute('evaluation_indiv', [
            "session" => $session->getId(),
            'stagiaire' => $utilisateur->getID()
        ]);
    }

    /**
     * @Route("/formateur/evaluations/ajouter", name="evaluation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evaluation = new Evaluation();
        $form = $this->createForm(EvaluationType::class, $evaluation);
        $form->handleRequest($request);
        $userRepository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $users = $userRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evaluation);
            $entityManager->flush();

            return $this->redirectToRoute('evaluation_index');
        }

        return $this->render('evaluation/new.html.twig', [
            'evaluation' => $evaluation,
            'form' => $form->createView(),
            'users' => $users
        ]);
    }

    /**
     * @Route("/evaluations/{id}/details", name="evaluation_show", methods={"GET"})
     */
    public function show(Evaluation $evaluation): Response
    {
        return $this->render('evaluation/show.html.twig', [
            'evaluation' => $evaluation,
        ]);
    }

    /**
     * @Route("/formateur/evaluations/{id}/editer", name="evaluation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evaluation $evaluation): Response
    {
        $form = $this->createForm(EvaluationType::class, $evaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evaluation_index');
        }

        return $this->render('evaluation/edit.html.twig', [
            'evaluation' => $evaluation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/formateur/evaluations/{id}/supprimer", name="evaluation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evaluation $evaluation): Response
    {
        if ($this->isCsrfTokenValid('delete' . $evaluation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evaluation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evaluation_index');
    }
}
