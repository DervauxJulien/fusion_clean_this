<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Client;
use App\Entity\Operation;
use App\Form\AdresseType;
use App\Form\ClientType;
use App\Form\OperationType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
    public function validate(EntityManagerInterface $em, Request $request): Response
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

            // J'envoi les données renseignées par le formulaire en base de donnée, comme c'est un formulaire imbriqué il faut respecter l'ordre des flush pour éviter les erreurs.

            // Flush de l'adresse en premier car pas de clé étrangère.
            $em->persist($adresse);
            $em->flush();

            // On renseigne l'adresse_id depuis l'entitée Adresse vers l'entité client sinon celle-ci sera définie comme nulle.

            $client->setAdresse($adresse);
            $em->persist($client);
            $em->flush();

            $operation->setStatus('à faire'); 
            $operation->setDateDemande(new \DateTime());
            $operation->setAdresse($adresse);
            $operation->setClient($client);
            $em->persist($operation);
            $em->flush();

            return $this->redirectToRoute('app_validation');
        }
        return $this->render('demande_operation/index.html.twig', [
            "createForm" => $form->createView()
        ]);
    }

    #[Route('/validation', name: 'app_validation')]
    public function validation(){
        return $this->render('demande_operation/validation.html.twig');
    }
}
