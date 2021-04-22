<?php

namespace App\Controller;

use App\Entity\CCP;
use App\Entity\TitreProfessionnel;
use App\Form\CCPType;
use App\Repository\CCPRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin")
 */
class CCPController extends AbstractController
{
    /**
     * @Route("/titres/ccp", name="c_c_p_index", methods={"GET"})
     */
    public function index(CCPRepository $cCPRepository): Response
    {
        return $this->render('ccp/index.html.twig', [
            'c_c_ps' => $cCPRepository->findAll(),
        ]);
    }

    /**
     * @Route("/titres/{titre}/ccp/ajouter/", name="titre_pro_c_c_p_new", methods={"GET","POST"})
     */
    public function new(Request $request, TitreProfessionnel $titre = null): Response
    {
        $cCP = new CCP();
        $form = $this->createForm(CCPType::class, $cCP);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $cCP->setTitreProfessionnel($titre);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cCP);
            $entityManager->flush();

            return $this->redirect($this->generateUrl("titre_professionnel_show", ['id' => $titre->getId()]));
        }

        return $this->render('ccp/new.html.twig', [
            'c_c_p' => $cCP,
            "titre" => $titre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/titres/cpp/{id}/details", name="c_c_p_show", methods={"GET"})
     */
    public function show(CCP $cCP): Response
    {
        return $this->render('ccp/show.html.twig', [
            'c_c_p' => $cCP,
        ]);
    }

    /**
     * @Route("/titre/{titre}/ccp/{ccp}/editer", name="titre_pro_c_c_p_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CCP $ccp, TitreProfessionnel $titre): Response
    {
        $form = $this->createForm(CCPType::class, $ccp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirect($this->generateUrl("titre_professionnel_show", ['id' => $titre->getId()]));
        }

        return $this->render('ccp/edit.html.twig', [
            'c_c_p' => $ccp,
            'titre' => $titre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/titre/{titre}/cpp/{ccp}/supprimer", name="c_c_p_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CCP $ccp, TitreProfessionnel $titre): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ccp->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ccp);
            $entityManager->flush();
        }
        return $this->redirect($this->generateUrl("titre_professionnel_show", ['id' => $titre->getId()]));
    }
}
