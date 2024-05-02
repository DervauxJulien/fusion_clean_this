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

    public function buildForm(FormBuilderInterface $builderClient, array $option){
        $builder 
        ->add('nom', Client::class)
        ->add('prenom', Client::class)
        ->add('email', Client::class)
        ->add('N_rue', Adresse::class)
        ->add('Nom_Rue', Adresse::class)
        ->add('Nom_Ville', Adresse::class)
        ->add('CP', Adresse::class)
        ->add('description_Op', Operation::class)
        ->add('img', Operation::class);
        
    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults([
            'data_class' => Client::class,
            'data_class' => Adresse::class,
            'data_class' => Operation::class
        ]);
    }

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

            // $em->persist($client);
            // $em->flush();

            // $em->persist($adresse);
            // $em->flush();

            
            // $em->persist($operation);
            // $em->flush();

            return $this->redirectToRoute('validation');
        }
        return $this->render('demande_operation/index.html.twig', [
            "createForm" => $form->createView()
        ]);
    }
}
