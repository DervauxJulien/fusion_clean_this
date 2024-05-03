<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;



class TableOpTermineesController extends AbstractController
{
    #[Route('/table/op/terminees', name: 'app_table_op_terminees')]
    public function index(UserRepository $userRepository,ClientRepository $clientRepository): Response
    {
        $test = 120;
       $clients = $clientRepository->FindAll();
       

        return $this->render('table_op_terminees/index.html.twig', [
            'test'=>$test,

        ]);
    }
}
