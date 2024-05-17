<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ClientRepository;
use App\Repository\OperationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OperationsàPrendreController extends AbstractController
{
    #[Route('/operations/prendre/', name: 'app_operations_prendre' , methods: ['GET'])]
    public function index(OperationRepository $operationRepository, ClientRepository $clientRepository, UserRepository $user): Response
    {
        // RECUPERATIONS DES DONNEES DES TABLES 'operation' et 'client'
        $stockOperation = $operationRepository->findAll();
        $stockCli = $clientRepository->findAll();
        // $getUrlStatus = $_GET['status'];
        
        return $this->render('operationsàprendre/index.html.twig', [
            'controller_name' => 'OperationsàPrendreController',
            'stockOperation' => $stockOperation,
            'stockCli' => $stockCli,
            'stringType' => $operationRepository->find(''),
            'users' => $user->findAll(),    
        ]);
    }

    #[Route('/operation/filter/{status}', name: 'app_operation_filter', methods: ['GET'])]

    public function filterByStatus(OperationRepository $operationRepository, $status): Response
    {
        // $status = $_GET['status'];

        $operations = $operationRepository->findByStatus($status);
        
        return $this->render('operationsàprendre/filter.html.twig', [
            'operations' => $operations,
            'getUrlStatus' => $status
        ]);
    }

    #[Route('/operation/ajout/{id}', name: 'app_operation_ajout')]
    public function ajout(OperationRepository $operationRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $user = $this->getUser();


    //Verification du nombre d'operation que l'utilisateur a ajouter
        $operationEnCours = $operationRepository->OperationEnCours($user->getId());

        if (!$user instanceof User) {
            throw new \LogicException('The user is not an instance of the User entity.');
        }
        if($operationEnCours >= 5){
            $this->addFlash("error", "Tu as deja atteint la limite d'opérations possible pour ton rôle !");
            return $this->redirectToRoute('app_opereration_prendre');
        }

        $operation = $operationRepository->find($id);

        $operation->setUser($user);
        $operation->setStatus('En cours');

        $entityManager->flush();

        return $this->redirectToRoute('app_operations_prendre');
        
    }
}
