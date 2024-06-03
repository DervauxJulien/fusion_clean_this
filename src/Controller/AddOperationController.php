<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Form\AddOperationFormType;
use App\Repository\AdresseRepository;
use App\Repository\ClientRepository;
use App\Repository\OperationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/operation')]
class AddOperationController extends AbstractController

{
    // Création de la route pour ajouter une opération
    #[Route('/add', name: 'app_add_operation')]
    public function index(OperationRepository $operationRepository, Request $request, EntityManagerInterface $entityManager, ClientRepository $clientRepository, UserRepository $userRepository): Response
    {

        $stockCli = $clientRepository->findAll();
        $stockOp = $operationRepository->findAll();
        $stockWaitOp = $operationRepository->findBy(['status' => 'En cours']);

        // Création d'une nouvelle instance d'Operation en dehors de la boucle
        $stock = new Operation();
        
        // Création du formulaire en utilisant l'entité Operation
        $form = $this->createForm(AddOperationFormType::class, $stock);

        // Je gère la soumission du formulaire
        $form->handleRequest($request);

        // Je check si le formulaire est soumis et valide

        if ($form->isSubmitted() && $form->isValid()) {
            $stock->setStatus('A faire');
            $entityManager->persist($stock);
            $entityManager->flush();

            // Redirection vers une route valide
            return $this->redirectToRoute('app_add_operation'); 
        }
        
        // J'affiche le form dans ma vue
        return $this->render('add_operation/index.html.twig', [
            'stockCli' => $stockCli,
            'stockOp' => $stockOp,
            'form' => $form->createView(),
            'stock' => $stock,
            'stockWaitOp' =>  $stockWaitOp,
            'users' => $userRepository,

        ]);
    }

    // Création de la route pour modifier l'opération
    #[Route('/edit/{id}', name: 'app_edit_operation')]
    public function editOperation(OperationRepository $operationRepository, Operation $operation, ClientRepository $clientRepository, Request $request, EntityManagerInterface $entityManager, AdresseRepository $adresseRepository, int $id ): Response
    {
        // Créer un formulaire de modification pour l'opération spécifique
        $stockOp = $operationRepository->find($id);
        $adresse = $adresseRepository->find($id);
        $client = $clientRepository->find($id);


        $form = $this->createForm(AddOperationFormType::class, $operation);
    
        // Gestion de la soumission du formulaire

        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            // mise à jour de "opération" avec les nouvelles données

            $operation->setDateCreation(new \DateTime()); // Ajoute automatiquement la date de l'ajout

            $operation->setStatus('A faire');  // Ajoute automatiquement le status "A faire"

            $entityManager->flush();

            return $this->redirectToRoute('app_add_operation');
        }
    
        // Afficher le formulaire de modification dans la vue

    
        return $this->render('add_operation/edit.html.twig', [
            'form' => $form->createView(),
            'operations' => $stockOp,
            'adresse' => $adresse,
            'client' => $client
        ]);
    }

    // Création de la route pour la suppression d'une opération
    #[Route('/{id}/remove', name: 'app_remove_operation')]
    public function remove(Operation $operation, EntityManagerInterface $entityManager): Response
    {
        // Ajoute un message flash pour préciser que l'opération à bien été supprimer
        $this->addFlash('danger', "La demande n° {$operation->getId()} a bien été supprimée.");

        $entityManager->remove($operation);

        $entityManager->flush();

        return $this->redirectToRoute('app_add_operation');
    }


}
