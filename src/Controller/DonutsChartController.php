<?php


// src/Controller/DonutsChartController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\OperationRepository;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DonutsChartController extends AbstractController
{
    public function DonutsChart(OperationRepository $operationRepository, ChartBuilderInterface $chartBuilder): Response
    {
        // Récupération des opérations terminées depuis le repository
        $operations = $operationRepository->findBy(['status' => 'Terminer']);

        // Initialisation des variables pour stocker les tarifs par type d'opération
        $petite = 0;
        $moyenne = 0;
        $grande = 0;
        $custom = 0;

        // Initialisation des variables pour stocker les tarifs par mois
        $monthlyData = array_fill(0, 12, 0);

        // Boucle sur chaque opération pour regrouper les tarifs par type d'opération et par mois
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

            // Ajout du tarif au mois correspondant
            if ($operation->getDateCreation()) {
                $month = $operation->getDateCreation()->format('n');
                $monthlyData[$month] += $operation->getTarif();
            }
        }

        // Calcul des pourcentages
        $total = $petite + $moyenne + $grande + $custom;
        $petitePercent = number_format(($petite * 100) / $total, 1);
        $moyennePercent = number_format(($moyenne * 100) / $total, 1);
        $grandePercent = number_format(($grande * 100) / $total, 1);
        $customPercent = number_format(($custom * 100) / $total, 1);

        // Création du graphique doughnut
        $chart = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);

        //Determination du moi sen cours
        $currentMonth = (int)date('n');

        //Création d'une table des mois jusqu'à celui en cours
        $currenArrayMonth = array_slice($monthlyData, 0, $currentMonth);
        $limitedLabels = array_slice(['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'], 0, $currentMonth);


        $chart->setData([
            'labels' => ['Petite manœuvre', 'Moyenne', 'Grosse', 'Custom'],
            'datasets' => [
                [
                    'label' => 'Tarifs par type d\'opération',
                    'data' => [$petite, $moyenne, $grande, $custom],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)'
                    ]
                ]
            ]
        ]);

        // Création du graphique line
        $chart2 = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart2->setData([
            'labels' => $limitedLabels,
            'datasets' => [
                [
                    'label' => 'Résultats de l\'année 2024',
                    'data' => $monthlyData,
                    'fill' => false,
                    'borderColor' => 'rgb(75, 192, 192)',
                    'tension' => 0.1,
                ]
            ]
        ]);

        return $this->render('donuts_chart/index.html.twig', [
            'petiteTarif' => $petite,
            'moyenneTarif' => $moyenne,
            'grandeTarif' => $grande,
            'customTarif' => $custom,
            'petitePercent' => $petitePercent,
            'moyennePercent' => $moyennePercent,
            'grandePercent' => $grandePercent,
            'customPercent' => $customPercent,
            'total' => $total,
            'operations' => $operations,
            'chart' => $chart,
            'chart2' => $chart2,
            'currentMonth'=>$currentMonth,
        ]);
    }
}
