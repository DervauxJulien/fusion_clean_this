<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\OperationRepository;

class TableController extends AbstractController
{
    #[Route('/table', name: 'table')]
    public function tableIndex(UserRepository $userRepository, OperationRepository $operationRepository): Response
    {

        $objectiveUser = 24100;

        // Récupération des opérations depuis le repository
        $operations = $operationRepository->findAll();
        // Initialisation d'un tableau pour stocker les statuts des opérations
        $status = [];
        // Boucle sur chaque opération pour obtenir son statut
        foreach ($operations as $operation) {
            $status[] = $operation->getStatus(); // Stocker chaque statut dans le tableau $statuts
        }

       

        return $this->render('table/index.html.twig', [
            // 'products' => $data,
            'objectiveUser' => $objectiveUser,
            'users' => $userRepository->findAll(),
            'operations' => $operations,
            'status' => $status,
        ]);

    }
}
