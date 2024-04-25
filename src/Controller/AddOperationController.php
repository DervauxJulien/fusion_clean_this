<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Operation;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddOperationController extends AbstractController
{
    #[Route('/add/operation', name: 'app_add_operation')]
    public function index(Operation $operation, Client $client, Request $request, EntityManagerInterface $entityManager) : Response
    {
        $operation = new Operation();
        $form = $this->createForm(AddOperationFormType::class, $client);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($operation);
            $entityManager->flush();

            return $this->redirectToRoute('/templates/home/index.html.twig');
        }

        return $this->render('add_operation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
