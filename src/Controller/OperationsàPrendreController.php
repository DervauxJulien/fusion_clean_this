<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Operation;
use App\Entity\User;
use App\Repository\ClientRepository;
use App\Repository\FactureRepository;
use App\Repository\OperationRepository;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OperationsàPrendreController extends AbstractController
{

    
    #[Route('/operations/prendre', name: 'app_operations_prendre' , methods: ['GET'])]
    public function index(OperationRepository $operationRepository, ClientRepository $clientRepository, UserRepository $user): Response
    {
        // RECUPERATIONS DES DONNEES DES TABLES 'operation' et 'client'
        
        $getUrlStatus = $_GET['status'].str_replace('%20', ' ', 'status');
        $stockOperation = $operationRepository->findAll();
        $stockCli = $clientRepository->findAll();
        $stockOpFilter = $operationRepository->findByStatus($_GET['status']);

        
        return $this->render('operationsàprendre/index.html.twig', [

            'controller_name' => 'OperationsàPrendreController',
            'stockOperation' => $stockOperation,
            'stockCli' => $stockCli,
            'stringType' => $operationRepository->find(''),
            'users' => $user->findAll(),
            'stockOpFilter' => $stockOpFilter
            
        ]);
    }
}
