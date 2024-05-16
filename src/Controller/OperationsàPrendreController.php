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
    #[Route('/operations/prendre/', name: 'app_operations_prendre' , methods: ['GET'])]
    public function index(OperationRepository $operationRepository, ClientRepository $clientRepository, UserRepository $user): Response
    {
        // RECUPERATIONS DES DONNEES DES TABLES 'operation' et 'client'
        
        $stockOperation = $operationRepository->findAll();
        $stockCli = $clientRepository->findAll();
        
        return $this->render('operationsàprendre/index.html.twig', [
            'controller_name' => 'OperationsàPrendreController',
            'operations' => $stockOperation,
            'stockCli' => $stockCli,
            'stringType' => $operationRepository->find(''),
            'users' => $user->findAll(),    
        ]);
    }

    #[Route('/operation/filter/{status}', name: 'app_operation_filter', methods: ['GET'])]

    public function filterByStatus(OperationRepository $operationRepository, $status): Response
    {
        $operations = $operationRepository->findByStatus($status);

        return $this->render('operationsàprendre/filter.html.twig', [
            'operations' => $operations,
            'getUrlStatus' => $status,
        ]);
    }

    #[Route('/operation/filter/{status}/{query?}', name: 'app_operation_filter_query', methods: ['GET'])]

    public function filterBySearch(OperationRepository $operationRepository, $status, $query = ''): Response
    {
        $operations = $operationRepository->findByStatus($status);
        $operationsSearch = [];

        if ($query !== '') {
            $operationsSearch = $operationRepository->findByClientName($query);
        }

        return $this->render('operationsàprendre/search.html.twig', [
            'operations' => $operations,
            'getUrlStatus' => $status,
            'operationsSearch' => $operationsSearch,
            'query' => $query,
        ]);
    }



}
