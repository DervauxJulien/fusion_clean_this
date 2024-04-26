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
        $statuts = [];

        // Boucle sur chaque opération pour obtenir son statut
        foreach ($operations as $operation) {
            $statut = $operation->getStatut();
        }
    
        $row = "SELECT
        u.nom AS nom_user,
        u.prenom AS prenom_user,
        COALESCE(SUM(COALESCE(f.prix_ht, 0) + COALESCE(f.tva, 0)), 0) AS chiffre_realise,
        COUNT(DISTINCT o.id) AS nombre_operations
    FROM
        user u
    LEFT JOIN operation o ON u.id = o.user_id
    LEFT JOIN client c ON u.id = c.id
    LEFT JOIN facture f ON c.id = f.client_id
    WHERE
        o.statut = 'Terminée'
    GROUP BY
        u.id, u.nom, u.prenom;"
        ;

        return $this->render('table/index.html.twig', [
            // 'products' => $data,
            'row' => $row,
            'objectiveUser' => $objectiveUser,
            'users' => $userRepository->findAll(),
            'operations' => $operations,
            'statuts' => $statuts,
        ]);

    }
}
