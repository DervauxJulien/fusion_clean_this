<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Form\AddOperationFormType;
use App\Repository\ClientRepository;
use App\Repository\OperationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddOperationController extends AbstractController
{
    #[Route('/add/operation', name: 'app_add_operation')]
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
            $stock->setStatut('A faire');
            // $stock->setAdresse();
            $entityManager->persist($stock);
            $entityManager->flush();

            // Redirection vers une route valide
            return $this->redirectToRoute('app_home'); // Remplacez 'app_home' par le nom de votre route valide
        }
        
        // J'affiche le form dans ma vue
        return $this->render('add_operation/index.html.twig', [
            'stockCli' => $stockCli,
            'stockOp' => $stockOp,
            'form' => $form->createView(),
            'stock' => $stock,
        ]);
    }

    #[Route('/edit/operation/{id}', name: 'app_edit_operation')]
    public function editOperation(OperationRepository $operationRepository, Operation $operation, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Créez un formulaire de modification pour l'opération spécifique
        $stockOp = $operationRepository->findAll();

        $form = $this->createForm(AddOperationFormType::class, $operation);
    
        // Gérez la soumission du formulaire

        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            // Mettez à jour l'opération avec les nouvelles données
            $operation->setStatut('a faire'); 
    
            $entityManager->flush();
    
            // Redirigez l'utilisateur vers une autre page après la modification

            return $this->redirectToRoute('app_home');
        }
    
        // Affichez le formulaire de modification dans votre vue Twig
        return $this->render('add_operation/edit.html.twig', [
            'form' => $form->createView(),
            'stockOp' => $stockOp,
        ]);
    }
}
