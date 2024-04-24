<?php
// src/Controller/SalesController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SalesController extends AbstractController
{
    public function salesStats(): Response
    {
        $currentYearSales = 150000;
        $percentage = 15;

        return $this->render('sales/stats.html.twig', [
            'currentYearSales' => $currentYearSales,
            'percentage' => $percentage,
        ]);
    }
}


?>