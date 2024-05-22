<?php
// src/Controller/DonutsChartController.php

namespace App\Controller;

use App\Entity\Operation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\OperationRepository;

class DonutsChartController extends AbstractController
{
    public function DonutsChart(OperationRepository $operationRepository): Response
    {
        // Récupération des opérations terminées depuis le repository
        $operations = $operationRepository->findBy(['status' => 'Realisé']);

        // Initialisation des variables pour stocker les tarifs par type d'opération
        $petite = 0;
        $moyenne = 0;
        $grande = 0;
        $custom = 0;
        $petitePercent= 0;
        $moyennePercent = 0;
        $grandePercent = 0;
        $customPercent = 0;


        // Boucle sur chaque opération pour regrouper les tarifs par type d'opération
        foreach ($operations as $operation) {
            switch ($operation->getType()) {
                case 'Petite manœuvre':
                    $petite += $operation->getTarif();
                    break;
                case 'Moyenne':
                    $moyenne += $operation->getTarif();
                    break;
                case 'Grosse':
                    $grande += $operation->getTarif();
                    break;
                case 'Custom':
                    $custom += $operation->getTarif();
                    break;
            }
        }

        //Calcule des pourcentages
        $total = $petite+$moyenne+$grande+$custom;
        $petitePercent = number_format( (($petite*100) / $total),1);
        $moyennePercent = number_format( (($moyenne*100) / $total),1);
        $grandePercent = number_format( (($grande*100) / $total),1);
        $customPercent = number_format( (($custom*100) / $total),1);

        return $this->render('donuts_chart/index.html.twig', [
            'petiteTarif' => $petite,
            'moyenneTarif' => $moyenne,
            'grandeTarif' => $grande,
            'customTarif' => $custom,
            'petitePercent' => $petitePercent,
            'moyennePercent' => $moyennePercent,
            'grandePercent' => $grandePercent,
            'customPercent' => $customPercent,
        ]);
            }
}
