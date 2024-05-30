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
    #[Route('/demande/operation', name: 'app_demande_operation')]
    public function valider(EntityManagerInterface $em, Request $request): Response
    {
        $client = new Client();
        $adresse = new Adresse();
        $operation = new Operation();

        $formulaire = $this->createFormBuilder()
            ->add('client', ClientType::class, ['data' => $client])
            ->add('adresse', AdresseType::class, ['data' => $adresse])
            ->add('operation', OperationType::class, ['data' => $operation])
            ->getForm();

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            // Persist de l'entité Adresse en premier car elle n'a pas de dépendances de clé étrangère.
            $em->persist($adresse);
            $em->flush();

            // Définir la référence de l'Adresse dans l'entité Client.
            $client->setAdresse($adresse);
            $em->persist($client);
            $em->flush();

            // Définir les détails de l'opération et les références.
            $operation->setStatus('En attente');
            $operation->setDateDemande(new \DateTime());
            $operation->setAdresse($adresse);
            $operation->setClient($client);
            $em->persist($operation);
            $em->flush();

            return $this->redirectToRoute('app_validation');
        }

        return $this->render('demande_operation/index.html.twig', [
            'createForm' => $formulaire->createView(),
        ]);
    }

    #[Route('/validation', name: 'app_validation')]
    public function validation(): Response
    {
        return $this->render('demande_operation/validation.html.twig');
    }
}
