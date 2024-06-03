<?php

namespace App\Controller;

use App\Repository\OperationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OperationAPrendreController extends AbstractController
{
    #[Route('/operation/{status}', name: 'app_operation_filter', methods: ['GET'])]
    public function filterByStatus(OperationRepository $operationRepository, string $status): Response
    {
        $user = $this->getUser();
        $operations = $operationRepository->findByStatus($status);
        $operationEnCours = $operationRepository->OperationEnCours($user->getId());

        return $this->render('operations_a_prendre/filter.html.twig', [
            'operations' => $operations,
            'getUrlStatus' => $status,
            'operationsEnCours' => $operationEnCours
        ]);
    }

    #[Route('/operation/search/{status}', name: 'app_operation_filter_query', methods: ['GET'])]
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

        return $this->render('operations_a_prendre/search.html.twig', [
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
        //Verification du nombre d'operation que l'utilisateur a ajouté
        $user = $this->getUser();
        $operationEnCours = $operationRepository->OperationEnCours($user->getId());

        if($operationEnCours >= 5){
            //Affichage d'un message 
            $this->addFlash("error", "Tu as deja atteint la limite d'opérations possible pour ton rôle !");
            return $this->redirectToRoute('app_opereration_prendre');
        }

        //Ciblage de l'operation a traiter
        $operation = $operationRepository->find($id);

        //Ajout d'un user sur l'operation
        $operation->setUser($user);
        //Changement du status de l'operation
        $operation->setStatus('En cours');


        //Envoie des changements dans la base de donnée
        $entityManager->flush();


        //redirection vers une route valide
        return $this->redirectToRoute('app_operation_filter', ['status' => 'A faire']);
    }

    
}
