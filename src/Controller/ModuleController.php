<?php

namespace App\Controller;

use App\Entity\CCP;
use App\Entity\Competence;
use App\Entity\Module;
use App\Entity\TitreProfessionnel;
use App\Form\ModuleType;
use App\Repository\ModuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * @Route("/admin")
 */
class ModuleController extends AbstractController
{
    /**
     * @Route("/titres/modules", name="module_index", methods={"GET"})
     */
    public function index(ModuleRepository $moduleRepository): Response
    {
        return $this->render('module/index.html.twig', [
            'modules' => $moduleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/titre/{titre}/ccp/{ccp}/competence/{competence}/module/ajouter", name="titre_pro_module_new", methods={"GET","POST"})
     */
    public function new(Request $request, TitreProfessionnel $titre, CCP $ccp, Competence $competence): Response
    {
        $module = new Module();
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $module->setCompetence($competence);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($module);
            $entityManager->flush();

            return $this->redirect($this->generateUrl("titre_professionnel_show", ['id' => $titre->getId()]));
        }

        return $this->render('module/new.html.twig', [
            'module' => $module,
            "titre" => $titre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/titres/modules/{id}/details", name="module_show", methods={"GET"})
     */
    public function show(Module $module): Response
    {
        return $this->render('module/show.html.twig', [
            'module' => $module,
        ]);
    }

    /**
     * @Route("/titre/{titre}/ccp/{ccp}/competence/{competence}/module/{module}/modifier", name="titre_pro_module_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TitreProfessionnel $titre, CCP $ccp, Competence $competence, Module $module): Response
    {
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirect($this->generateUrl("titre_professionnel_show", ['id' => $titre->getId()]));
        }

        return $this->render('module/edit.html.twig', [
            'module' => $module,
            'titre' => $titre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/titre/{titre}/module/{id}/supprimer", name="module_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Module $module, TitreProfessionnel $titre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$module->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($module);
            $entityManager->flush();
        }
        return $this->redirect($this->generateUrl("titre_professionnel_show", ['id' => $titre->getId()]));
    }
}
