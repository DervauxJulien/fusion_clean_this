<?php
// src/Controller/SalesController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\OperationRepository;

class SalesController extends AbstractController
{
    public function salesStats(OperationRepository $operationRepository): Response
    {
        // Récupération des opérations depuis le repository
        $operations = $operationRepository->findAll();

        // Initialisation des variables
        $currentYearSales = 0;
        $percentageCurrentSales = 0;

        // Calcul des ventes de l'année en cours
        foreach ($operations as $operation) {
            $currentYearSales += $operation->getTarif();
        }
        
        // Calcul du pourcentage de ventes par rapport à l'objectif
        $percentageCurrentSales = number_format((($currentYearSales * 100) / 120500), 1);

        // Définition des autres variables
        $percentageObjectif = 5.4;
        $objectif = 120500;
        $monthSales = 6250;
        $percentageMonthSales = number_format((($monthSales * 100) / 24100), 1);

        // Rendu de la vue avec les données
        return $this->render('sales/stats.html.twig', [
            'currentYearSales' => $currentYearSales,
            'percentageCurrentSales' => $percentageCurrentSales,
            'monthSales' => $monthSales,
            'objectif' => $objectif,
            'percentageObjectif' => $percentageObjectif,
            'percentageMonthSales' => $percentageMonthSales,
            'operations' => $operations,
        ]);
    }
}
?>
