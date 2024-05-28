<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\Operation;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use App\Repository\OperationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OperationsInProgressController extends AbstractController
{
    #[Route('/operations/in/progress', name: 'app_operations_in_progress')]
    public function index(OperationRepository $operationRepository, ClientRepository $clientRepository, UserRepository $userRepository): Response
    {
        // RECUPERATIONS DES DONNEES DES TABLES 'operation' et 'client'
        $stockOperation = $operationRepository->findAll();
        $stockClient = $clientRepository->findAll();
        $stockUser = $userRepository->findAll();

        return $this->render('operations_in_progress/index.html.twig', [
            'controller_name' => 'OperationsInProgressController',
            'stockOperation' => $stockOperation,
            'stockClient' => $stockClient,
            'stockUser' => $stockUser,
        ]);
    }
}
