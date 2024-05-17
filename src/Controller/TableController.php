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
                // Récupération de tous les utilisateurs
                $users = $userRepository->findAll();

                // Calcul dynamique du nombre d'utilisateurs
                $numberOfUsers = count($users);
        
        
        // Récupération de l'objectif depuis la session
        $objectifLocSto = $request->getSession()->get('objectif');
        $objectif = $objectifLocSto;

        //Calcul de l'objectif par user
        // $objectiveUser = number_format(($objectif/8),0) ;

        // Calcul de l'objectif par utilisateur en fonction du nombre d'utilisateurs
        $objectiveUser = number_format(($objectif / $numberOfUsers), 0);

        
        // Si l'objectif n'est pas encore défini dans la session, on utilise la valeur par défaut
        if ($objectif == 0) {
            $objectif = 220500;
            $objectiveUser = 27561;
        }


        
        // Récupération des opérations depuis le repository
        $operations = $operationRepository->findAll();

        // Initialisation d'un tableau pour stocker les statuts des opérations
        $statuts = [];


        // Récupération de tous les utilisateurs
        // $users = $userRepository->findAll();

        // Initialisation d'un tableau pour stocker les réalisations par utilisateur
        $realisations = [];

        // Calcul de la réalisation et de la progression pour chaque utilisateur
        foreach ($users as $user) {
            $userRealisation = 0;

        // Parcours des opérations pour trouver celles associées à cet utilisateur
        foreach ($operations as $operation) {
            if ($operation->getUser() === $user) {
                $userRealisation += $operation->getTarif();
            }
        }

            // Stockage de la réalisation pour cet utilisateur
            $realisations[$user->getId()] = $userRealisation;
        }

        
        
        // Boucle sur chaque opération pour obtenir son statut
        foreach ($operations as $operation) {
            $statuts[] = $operation->getStatus(); // Stocker chaque statut dans le tableau $statuts
        }

        return $this->render('table/index.html.twig', [
            'objectiveUser' => $objectiveUser,
            'users' => $users,
            'operations' => $operations,
            'statuts' => $statuts,
            'objectif' => $objectif,
            'objectifLocSto'=>$objectifLocSto,
            'realisations' => $realisations,
            'numberUser' => $numberOfUsers,
        ]);
    }
}
