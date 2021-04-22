<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(SessionRepository $sessionRepository): Response
    {
        if(TRUE === $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            return $this->render('dashboard/dashboard.twig', [
                'sessions' => $sessionRepository->findAll(),
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    /**
     * @Route("/accessDenied", name="accessDenied")
     */
    public function accessDenied(): Response
    {
        if (FALSE === $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_login');
        } else {
            return $this->render('dashboard/accessDenied.twig');
        }
    }
}