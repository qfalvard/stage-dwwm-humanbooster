<?php

namespace App\Controller;

use App\Entity\CCP;
use App\Entity\Competence;
use App\Entity\Module;
use App\Entity\Objectif;
use App\Form\ObjectifType;
use App\Entity\TitreProfessionnel;
use App\Repository\ObjectifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class ObjectifController extends AbstractController
{
    /**
     * @Route("/titres/objectifs", name="objectif_index", methods={"GET"})
     */
    public function index(ObjectifRepository $objectifRepository): Response
    {
        return $this->render('objectif/index.html.twig', [
            'objectifs' => $objectifRepository->findAll(),
        ]);
    }

    /** 
     * @Route("/titre/{titre}/ccp/{ccp}/competence/{competence}/module/{module}/objectif/ajouter", name="titre_pro_objectif_new", methods={"GET","POST"})
     */
    public function new(Request $request, TitreProfessionnel $titre, Module $module): Response
    {
        $objectif = new Objectif();
        $form = $this->createForm(ObjectifType::class, $objectif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objectif->setModule($module);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($objectif);
            $entityManager->flush();
            return $this->redirect($this->generateUrl("titre_professionnel_show", ['id' => $titre->getId()]));
        }

        return $this->render('objectif/new.html.twig', [
            'objectif' => $objectif,
            'form' => $form->createView(),
            "titre" => $titre,
        ]);
    }

    /**
     * @Route("/titres/objectifs/{id}/details", name="objectif_show", methods={"GET"})
     */
    public function show(Objectif $objectif): Response
    {
        return $this->render('objectif/show.html.twig', [
            'objectif' => $objectif,
        ]);
    }

    /**
     * @Route("/titre/{titre}/ccp/{ccp}/competence/{competence}/module/{module}/objectif/{objectif}/modifier", name="titre_pro_objectif_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Objectif $objectif, Module $module, TitreProfessionnel $titre): Response
    {
        $form = $this->createForm(ObjectifType::class, $objectif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl("titre_professionnel_show", ['id' => $titre->getId()]));
        }

        return $this->render('objectif/edit.html.twig', [
            'objectif' => $objectif,
            'titre' => $titre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/titre/{titre}/objects/{id}/supprimer", name="objectif_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Objectif $objectif, TitreProfessionnel $titre): Response
    {
        if ($this->isCsrfTokenValid('delete' . $objectif->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($objectif);
            $entityManager->flush();
        }
        
        return $this->redirect($this->generateUrl("titre_professionnel_show", ['id' => $titre->getId()]));
    }
}
