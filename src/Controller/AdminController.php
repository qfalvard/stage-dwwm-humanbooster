<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\EditUserType;
use App\Form\RegistrationFormType;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/utilisateurs", name="utilisateurs_index")
     */
    public function usersList(UtilisateurRepository $users)
    {
        return $this->render('admin/users.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    // public function Dashboard()
    // {
    //     if (TRUE === $this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
    //         return $this->render('views/dashboard.twig');
    //     } else {
    //         return $this->render('security/login.html.twig');
    //     }
    // }

    /**
     * @Route("/utilisateurs/{id}/edit", name="utilisateurs_edit", methods={"GET","POST"})
     */
    public function usersEdit(Request $request, Utilisateur $user)
    {
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);
        $roles = $user->getRoles();

        if ($form->isSubmitted() && $form->isValid()) {
            if (in_array("ROLE_FORMATEUR_TRE", $roles) && !in_array("ROLE_FORMATEUR", $roles)) {
                array_push($roles, "ROLE_FORMATEUR");
                $user->setRoles($roles);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisateurs_index');
        }

        return $this->render('admin/userEdit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
