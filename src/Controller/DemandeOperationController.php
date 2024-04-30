<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Client;
use App\Entity\Operation;
use App\Form\AdresseType;
use App\Form\ClientType;
use App\Form\OperationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeOperationController extends AbstractController
{
    // #[Route('/demande/operation', name: 'app_demande_operation')]
    // public function index(): Response
    // {
    //     return $this->render('demande_operation/index.html.twig', [
    //         'controller_name' => 'DemandeOperationController',
    //     ]);
    // }

    #[Route('/demande/operation', name: 'app_demande_operation')]
    public function validate(Request $request, EntityManagerInterface $em): Response
    {
        $client = new Client();
        $adresse = new Adresse();
        $operation = new Operation();

        $form = $this->createFormBuilder()
            ->add('client', ClientType::class, ['data' => $client])
            ->add('adresse', AdresseType::class, ['data' => $adresse])
            ->add('operation', OperationType::class, ['data' => $operation])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $data = $form->getData();

            $em->persist($client);
            $em->flush();

            $em->persist($client);
            $em->persist($adresse);
            $em->flush();

            $em->persist($client);
            $em->persist($adresse);
            $em->persist($operation);
            $em->flush();

            return $this->redirectToRoute('validation');
        }
        return $this->render('demande_operation/index.html.twig', [
            "createForm" => $form->createView()
        ]);
    }
}
