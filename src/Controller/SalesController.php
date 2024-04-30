<?php
// src/Controller/SalesController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SalesController extends AbstractController
{
    public function salesStats(): Response
    {
        $currentYearSales = 12500;
        $percentageCurrentSales = number_format((($currentYearSales * 100) / 120500), 1);
        $percentageObjectif = 5.4;
        $monthSales = 6250;
        $percentageMonthSales =number_format((($monthSales * 100) / 24100), 1);
        $objectif = 120500;

        return $this->render('sales/stats.html.twig', [
            'currentYearSales' => $currentYearSales,
            'percentageCurrentSales' => $percentageCurrentSales,
            'monthSales' => $monthSales,
            'objectif' => $objectif,
            'percentageObjectif' => $percentageObjectif,
            'percentageMonthSales' => $percentageMonthSales,
        ]);
    }
}


?>