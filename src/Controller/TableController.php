<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;


class TableController extends AbstractController
{
    #[Route('/table', name: 'table')]
    public function tableIndex(UserRepository $userRepository): Response
    {

        $objectiveUser = 24100;

        $data = [
            ['name' => 'Martin Ali', 'status' => 'Expert', 'objective' => 24100, 'realization' => 19300, 'operations'=>19],
            ['name' => 'Glisse Alice', 'status' => 'Apprenti', 'objective' => 24100, 'realization' => 17200, 'operations'=>16],
            ['name' => 'Terrieur Alex', 'status' => 'Senior', 'objective' => 24100, 'realization' => 14100,'operations'=>12],
            ['name' => 'Darme Jean', 'status' => 'Senior', 'objective' => 24100, 'realization' => 11400,'operations'=>10],
            ['name' => 'Etrange Caroline ', 'status' => 'Apprenti', 'objective' => 24100, 'realization' => 8850,'operations'=>8],
        ];

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
        u.id, u.nom, u.prenom;
    ";
// var_dump($row);


        return $this->render('table/index.html.twig', [
            'products' => $data,
            'row' => $row,
            'objectiveUser' => $objectiveUser,
            'users' => $userRepository->findAll(),
        ]);

    }
}
    








    

