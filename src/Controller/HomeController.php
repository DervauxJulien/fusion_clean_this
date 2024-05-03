<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/tarif', name: 'app_tarif')]
    public function tarif(): Response
    {
        return $this->render('home/tarif.html.twig');
    }

    #[Route('/mentionL', name: 'app_mentionL')]
    public function mentionL(): Response
    {
        return $this->render('home/mentionL.html.twig');
    }

    #[Route('/CG', name: 'app_cguCgv')]
    public function cguCgv(): Response
    {
        return $this->render('home/cguCgv.html.twig');
    }
}
