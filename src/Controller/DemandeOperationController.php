<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DemandeOperationController extends AbstractController
{
    #[Route('/demande/operation', name: 'app_demande_operation')]
    public function index(): Response
    {
        return $this->render('demande_operation/index.html.twig', [
            'controller_name' => 'DemandeOperationController',
        ]);
    }
}
