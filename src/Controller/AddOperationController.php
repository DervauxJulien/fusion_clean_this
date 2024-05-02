<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Operation;
use App\Form\AddOperationFormType;
use App\Repository\AdresseRepository;
use App\Repository\ClientRepository;
use App\Repository\OperationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/operation')]
class AddOperationController extends AbstractController

{
    #[Route('/add', name: 'app_add_operation')]
    public function index(OperationRepository $operationRepository, Request $request, EntityManagerInterface $entityManager, ClientRepository $clientRepository): Response
    {

        $stockCli = $clientRepository->findAll();
        $stockOp = $operationRepository->findAll();

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
        ]);
    }

    #[Route('/edit/{id}', name: 'app_edit_operation')]
    public function editOperation(OperationRepository $operationRepository, Operation $operation, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Créez un formulaire de modification pour l'opération spécifique
        $stockOp = $operationRepository->findAll();

        $form = $this->createForm(AddOperationFormType::class, $operation);
    
        // Gérez la soumission du formulaire

        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            // Mettez à jour l'opération avec les nouvelles données
            $operation->setStatus('a faire'); 
    
            $entityManager->flush();
    
            // Redirigez l'utilisateur vers une autre page après la modification

            return $this->redirectToRoute('app_add_operation');
        }
    
        // Affichez le formulaire de modification dans votre vue Twig
        return $this->render('add_operation/edit.html.twig', [
            'form' => $form->createView(),
            'stockOp' => $stockOp,
        ]);
    }

    #[Route('/{id}/remove', name: 'app_remove_operation')]
    public function remove(Operation $operation, EntityManagerInterface $entityManager): Response
    {
        $this->addFlash('danger', "L'utilisateur {$operation->getId()} a bien été supprimer.");

        $entityManager->remove($operation);
        $entityManager->flush();

        
        return $this->redirectToRoute('app_add_operation');
    }
}
