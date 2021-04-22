<?php

namespace App\Controller;

use App\Entity\CCP;
use App\Entity\Competence;
use App\Entity\TitreProfessionnel;
use App\Form\CompetenceType;
use App\Repository\CompetenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin")
 */
class CompetenceController extends AbstractController
{
    /**
     * @Route("/titres/competences", name="competence_index", methods={"GET"})
     */
    public function index(CompetenceRepository $competenceRepository): Response
    {
        return $this->render('competence/index.html.twig', [
            'competences' => $competenceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/titres/{titre}/ccp/{ccp}/competence/ajouter/", name="titre_pro_competence_new", methods={"GET","POST"})
     */
    public function new(Request $request, TitreProfessionnel $titre, CCP $ccp): Response
    {
        $competence = new Competence();
        $form = $this->createForm(CompetenceType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competence->setCcp($ccp);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competence);
            $entityManager->flush();

            return $this->redirect($this->generateUrl("titre_professionnel_show", ['id' => $titre->getId()]));
        }

        return $this->render('competence/new.html.twig', [
            'competence' => $competence,
            "titre" => $titre,
            'form' => $form->createView(),
            
        ]);
    }

    /**
     * @Route("/titre/{titre}/competence/{id}/editer", name="titre_pro_competence_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Competence $competence,TitreProfessionnel $titre): Response
    {
        $form = $this->createForm(CompetenceType::class, $competence);
        $form->handleRequest($request);
        $referer = $request->server->get('HTTP_REFERER');
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirect($this->generateUrl("titre_professionnel_show", ['id' => $titre->getId()]));
        }

        return $this->render('competence/edit.html.twig', [
            'competence' => $competence,
            'titre' => $titre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/titre/{titre}/competence/{id}/supprimer", name="competence_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Competence $competence, TitreProfessionnel $titre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competence->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($competence);
            $entityManager->flush();
        }
        return $this->redirect($this->generateUrl("titre_professionnel_show", ['id' => $titre->getId()]));
    }
}
