<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TableController extends AbstractController
{
    #[Route('/table', name: 'table')]
    public function tableIndex(): Response
    {



        $data = [
            ['name' => 'Martin Ali', 'status' => 'Expert', 'objective' => 24100, 'realization' => 19300, 'operations'=>19],
            ['name' => 'Glisse Alice', 'status' => 'Apprenti', 'objective' => 24100, 'realization' => 17200, 'operations'=>16],
            ['name' => 'Terrieur Alex', 'status' => 'Senior', 'objective' => 24100, 'realization' => 14100,'operations'=>12],
            ['name' => 'Darme Jean', 'status' => 'Senior', 'objective' => 24100, 'realization' => 11400,'operations'=>10],
            ['name' => 'Etrange Caroline ', 'status' => 'Apprenti', 'objective' => 24100, 'realization' => 8850,'operations'=>8],
        ];


        // $entityManager = $this->getDoctrine()->getManager();
        // $connection = $entityManager->getConnection();

        // $sql = "SELECT nom, prenom, roles FROM user;";
        // $statement = $connection->prepare($sql);
        // $statement->execute();

        // $data = $statement->fetchAllAssociative();




        return $this->render('table/index.html.twig', [
            'products' => $data,
        ]);

    }
}
    








    

// class MyTableController extends AbstractController
// {
//     #[Route('/table', name: 'table')]
//     public function tableIndex(): Response
//     {
//         $entityManager = $this->getDoctrine()->getManager();
//         $connection = $entityManager->getConnection();

//         $sql = "SELECT nom, prenom, roles FROM user;";
//         $statement = $connection->prepare($sql);
//         $statement->execute();

//         $data = $statement->fetchAllAssociative();

//         return $this->render('table/index.html.twig', [
//             'products' => $data,
//         ]);
//     }
// }
