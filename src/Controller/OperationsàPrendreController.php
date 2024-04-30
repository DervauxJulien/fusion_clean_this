<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Operation;
use App\Repository\ClientRepository;
use App\Repository\FactureRepository;
use App\Repository\OperationRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OperationsàPrendreController extends AbstractController
{
    #[Route('/operations/prendre', name: 'app_operations_prendre' , methods: ['GET'])]
    public function index(OperationRepository $operationRepository, ClientRepository $clientRepository, FactureRepository $factureRepository): Response
    {
        // RECUPERATIONS DES DONNEES DES TABLES 'operation' et 'client'
        $stockOp = $operationRepository->findAll();
        $stockCli = $clientRepository->findAll();
        $stockFac = $factureRepository->findAll();

        return $this->render('operationsàprendre/index.html.twig', [
            'controller_name' => 'OperationsàPrendreController',
            
            'stockOp' => $stockOp,
            'stockCli' => $stockCli,
            'stringType' => $operationRepository->find(''),
            'stockFac' => $stockFac,
        ]);
    }
}
