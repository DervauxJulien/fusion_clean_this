<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\OperationRepository;

class TableController extends AbstractController
{
    #[Route('/table', name: 'table')]
    public function tableIndex(Request $request, UserRepository $userRepository, OperationRepository $operationRepository): Response
    {
        
        // Récupération de l'objectif depuis la session
        $objectif = $request->getSession()->get('objectif');
        //Calcul de l'objectif par user
        $objectiveUser = number_format(($objectif/8),0) ;
        // $objectiveUser = 27500;
        
        // Si l'objectif n'est pas encore défini dans la session, on utilise la valeur par défaut
        if (!$objectif) {
            $objectif = 220500;
            $objectiveUser = 27560;
        }
        

        // Récupération des opérations depuis le repository
        $operations = $operationRepository->findAll();
        
        // Initialisation d'un tableau pour stocker les statuts des opérations
        $statuts = [];
        
        // Boucle sur chaque opération pour obtenir son statut
        foreach ($operations as $operation) {
            $statuts[] = $operation->getStatus(); // Stocker chaque statut dans le tableau $statuts
        }

        return $this->render('table/index.html.twig', [
            'objectiveUser' => $objectiveUser,
            'users' => $userRepository->findAll(),
            'operations' => $operations,
            'statuts' => $statuts,
            'objectif' => $objectif,
        ]);
    }
}
