<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\OperationRepository;
use App\Repository\FactureRepository;

class TableController extends AbstractController
{
    #[Route('/table', name: 'table')]
    public function tableIndex(UserRepository $userRepository, OperationRepository $operationRepository, FactureRepository $factureRepository): Response
    {

        $objectiveUser = 24100;

        // Récupération des opérations depuis le repository
        $operations = $operationRepository->findAll();
        // Initialisation d'un tableau pour stocker les statuts des opérations
        $statuts = [];
        // Boucle sur chaque opération pour obtenir son statut
        foreach ($operations as $operation) {
            $statuts[] = $operation->getStatut(); // Stocker chaque statut dans le tableau $statuts
        }

        $factures = $factureRepository->findAll();
        $prixFactures = [];

        foreach ($factures as $facture) {
            $prixFactures[] = $facture->getPrixHt(); // Stocker chaque prix dans le tableau $prixFactures
        }



        return $this->render('table/index.html.twig', [
            // 'products' => $data,
            'objectiveUser' => $objectiveUser,
            'users' => $userRepository->findAll(),
            'operations' => $operations,
            'statuts' => $statuts,
            'prixFactures' => $prixFactures,
        ]);

    }
}
