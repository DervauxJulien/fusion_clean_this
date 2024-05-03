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
        $operation = $operationRepository->FindAll();
        $stockOperation = $operationRepository->findAll();
        // $stockCli = $clientRepository->findAll();

    


        return $this->render('table_op_terminees/index.html.twig', [
            'clients' => $clients,
            'stockOperation' => $stockOperation,
            // 'stockCli' => $stockCli,
            'stringType' => $operationRepository->find(''),

        ]);
    }
}



?>