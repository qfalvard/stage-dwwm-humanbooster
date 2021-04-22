<?php

namespace App\Controller;

use App\Entity\TitreProfessionnel;
use App\Form\TitreProfessionnelType;
use App\Repository\CCPRepository;
use App\Repository\CompetenceRepository;
use App\Repository\ModuleRepository;
use App\Repository\ObjectifRepository;
use App\Repository\TitreProfessionnelRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class TitreProfessionnelController extends AbstractController
{
    /**
     * @Route("/titres", name="titre_professionnel_index", methods={"GET"})
     */
    public function index(
        TitreProfessionnelRepository $titreProfessionnelRepository,
        CCPRepository $ccps,
        CompetenceRepository $competences,
        ModuleRepository $modules,
        ObjectifRepository $objectifs
        ): Response
    {
        // dd(
        //     $ccps->findAll(),
        //     $competences->findAll(),
        //     $modules->findAll(),
        //     $objectifs->findAll());
        return $this->render('titre_professionnel/index.html.twig', [
            'titre_professionnels' => $titreProfessionnelRepository->findAll(),
            'ccps' => $ccps->findAll(),
            'competences' => $competences->findAll(),
            'modules' => $modules->findAll(),
            'objectifs' => $objectifs->findAll(),
        ]);
    }

    /**
     * @Route("/admin/titres/ajouter", name="titre_professionnel_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $titreProfessionnel = new TitreProfessionnel();
        $form = $this->createForm(TitreProfessionnelType::class, $titreProfessionnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($titreProfessionnel);
            $entityManager->flush();
            
            return $this->redirectToRoute('titre_professionnel_index');
        }

        return $this->render('titre_professionnel/new.html.twig', [
            'titre_professionnel' => $titreProfessionnel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/titres/{id}", name="titre_professionnel_show", methods={"GET"})
     */
    public function show(TitreProfessionnel $titreProfessionnel,
        CCPRepository $ccps,
        CompetenceRepository $competences,
        ModuleRepository $modules,
        ObjectifRepository $objectifs
    ): Response
    {
        return $this->render('titre_professionnel/show.html.twig', [
            'titre_professionnel' => $titreProfessionnel,
            'ccps' => $ccps->findAll(),
            'competences' => $competences->findAll(),
            'modules' => $modules->findAll(),
            'objectifs' => $objectifs->findAll(),
        ]);
    }

    /**
     * @Route("/admin/titres/{id}/editer", name="titre_professionnel_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TitreProfessionnel $titreProfessionnel): Response
    {
        $form = $this->createForm(TitreProfessionnelType::class, $titreProfessionnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('titre_professionnel_index');
        }

        return $this->render('titre_professionnel/edit.html.twig', [
            'titre_professionnel' => $titreProfessionnel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/titres/{id}/supprimer", name="titre_professionnel_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TitreProfessionnel $titreProfessionnel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$titreProfessionnel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($titreProfessionnel);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Le titre professionnel a été supprimé');

        return $this->redirectToRoute('titre_professionnel_index');
    }

    /**
     * @Security("is_granted('ROLE_ENCADRANT')", message="Accréditation innsuffisante.")
     * @Route("/admin/titres/{id}/disable", name="titre_professionnel_disable")
     */
    public function disable(Request $request, TitreProfessionnel $titreProfessionnel): Response
    {
        if (FALSE === $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            return $this->redirectToRoute('app_login');
        }
        
            $entityManager = $this->getDoctrine()->getManager();
            $titreProfessionnel->setIsActif(false);
            $entityManager->flush();

        return $this->redirectToRoute('titre_professionnel_index');
    }
}
