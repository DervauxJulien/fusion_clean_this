<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use App\Repository\OperationRepository;

class TableOpTermineesController extends AbstractController
{
    #[Route('/table/op/terminees', name: 'app_table_op_terminees')]
    public function table_op_termineesIndex(ClientRepository $clientRepository, OperationRepository $operationRepository): Response
    {
        $clients = $clientRepository->findAll();
        $operations = $operationRepository->findAll();
        $stockOperation = $operationRepository->findAll();

        // Tri des opérations par le nom du client
        usort($operations, function ($a, $b) {
            return strcmp($a->getClient()->getNom(), $b->getClient()->getNom());
        });
    
        $operationDetails = [];
    
        foreach ($operations as $operation) {
            $user = $operation->getUser(); 
            $operationDetails[] = [
                'nom_utilisateur' => $user ? $user->getNom() : 'Utilisateur inconnu',
            ];
        }
    
        return $this->render('table_op_terminees/index.html.twig', [
            'clients' => $clients,
            'operations' => $stockOperation,
            'operationDetails' => $operationDetails,
            'operations'=> $operations,
        ]);
    }
    }



?>