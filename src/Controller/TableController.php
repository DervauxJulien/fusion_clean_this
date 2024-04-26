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



        $data = [
            ['name' => 'Martin Ali', 'status' => 'Expert', 'objective' => 24100, 'realization' => 19300, 'operations'=>19],
            ['name' => 'Glisse Alice', 'status' => 'Apprenti', 'objective' => 24100, 'realization' => 17200, 'operations'=>16],
            ['name' => 'Terrieur Alex', 'status' => 'Senior', 'objective' => 24100, 'realization' => 14100,'operations'=>12],
            ['name' => 'Darme Jean', 'status' => 'Senior', 'objective' => 24100, 'realization' => 11400,'operations'=>10],
            ['name' => 'Etrange Caroline ', 'status' => 'Apprenti', 'objective' => 24100, 'realization' => 8850,'operations'=>8],
        ];




        return $this->render('table/index.html.twig', [
            'products' => $data,
            'users' => $userRepository->findAll(),
        ]);

    }
}
    








    

