<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\OperationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OperationsàPrendreController extends AbstractController
{
    // #[Route('/operations/prendre/filter/{status}', name: 'app_operations_prendre', methods: ['GET'])]
    // public function index(OperationRepository $operationRepository,string $status): Response
    // {
    //     $stockOperation = $operationRepository->findAll();
    //     $user = $this->getUser();
    //     $operationEnCours = $operationRepository->OperationEnCours($user->getId());
    //     $status = "A faire";

    //     return $this->render('operationsàprendre/filter.html.twig', [
    //         'operations' => $stockOperation,
    //         'operationsEnCours' => $operationEnCours,
    //         'getUrlStatus' => $status,
    //     ]);
    // }

    #[Route('/operation/filter/{status}', name: 'app_operation_filter', methods: ['GET'])]
    public function filterByStatus(OperationRepository $operationRepository, string $status): Response
    {
        $user = $this->getUser();
        $operations = $operationRepository->findByStatus($status);
        $operationEnCours = $operationRepository->OperationEnCours($user->getId());

        return $this->render('operationsàprendre/filter.html.twig', [
            'operations' => $operations,
            'getUrlStatus' => $status,
            'operationsEnCours' => $operationEnCours
        ]);
    }

    #[Route('/operation/filter/search/{status}', name: 'app_operation_filter_query', methods: ['GET'])]
    public function findOneByClientName(OperationRepository $operationRepository, string $status, Request $request): Response
    {
        $user = $this->getUser();
        $query = $request->query->get('query', '');
        $operations = $operationRepository->findByStatus($status);
        $operationsSearch = [];
        $operationEnCours = $operationRepository->OperationEnCours($user->getId());

        if ($query !== null && $query !== '') {
            $operationsSearch = $operationRepository->findOneByClientName($query);
        }

        return $this->render('operationsàprendre/search.html.twig', [
            'operations' => $operations,
            'getUrlStatus' => $status,
            'operationsSearch' => $operationsSearch,
            'query' => $query,
            'operationsEnCours' => $operationEnCours
        ]);
    }

    #[Route('/operation/ajout/{id}', name: 'app_operation_ajout')]
    public function ajoutOperation(OperationRepository $operationRepository, EntityManagerInterface $entityManager, int $id): Response
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
