<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OperationsTermineesController extends AbstractController
{
    #[Route('/operations/terminees', name: 'app_operations_terminees')]
    public function index(): Response
    {
        return $this->render('operations_terminees/index.html.twig', [
            'controller_name' => 'OperationsTermineesController',
        ]);
    }
}
