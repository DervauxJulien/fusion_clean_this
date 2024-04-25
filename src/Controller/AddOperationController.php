<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Form\AddOperationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddOperationController extends AbstractController
{
    #[Route('/add/operation', name: 'app_add_operation')]
    public function index(Operation $operation, Request $request, EntityManagerInterface $entityManager) : Response
    {
        // Création d'une instance de l'entité Operation

        $operation = new Operation();

         // Création d'un formulaire en utilisant l'entité Operation

        $form = $this->createForm(AddOperationFormType::class, $operation);

        // Je gère la soumission du formulaire

        $form -> handleRequest($request);

        // Je check si le formulaire est soumis et valide

        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($operation);
            $entityManager->flush();

            return $this->redirectToRoute('/templates/home/index.html.twig');
        }

        // J'affiche le form dans ma vue

        return $this->render('add_operation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
