<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateUserFormType;
use App\Form\ModifUserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/user')]
class UserController extends AbstractController
{
    
    /**
     * Index
     *
     * @param UserRepository $userRepository
     * @return Response
     */
    // Affichage des Utilisateur
    #[Route('/', name: 'app_gestion_utilisateur')]
    public function index( UserRepository $userRepository): Response
    {
       
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            
        ]);
    }


    /**
     * Create
     *
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @return Response
     */
    
    // Creation d'un nouvel utilisateur
    #[Route('/create', name: 'app_gestion_utilisateur_create')]
    public function create(User $user, EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        // Création d'une nouvelle instance de User
        $user = new User();
       
        //Création du formulaire a partir de `src/Form/CreateUserFormType`
        $form = $this->createForm(CreateUserFormType::class, $user);

        //Soumission du formulaire
        $form->handleRequest($request);

        // Verification si le formulaire est soumis et est valide
        if($form->isSubmitted() && $form->isValid())
        {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            //envoi des données dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();

            //Affichage d'un message informant du succes de l'ajout du user
            $this->addFlash('success', "L'utilisateur {$user->getUsername()} a bien été ajouter.");

            //Redirection vers une route valide
            return $this->redirectToRoute('app_gestion_utilisateur');
        }

        //Affichage du form dans la vue
        return $this->render('user/create.html.twig',[
            "creatForm" => $form
        ]);
    }


     /**
     * Modif
     *
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    //Modification global de l'utilisateur
    #[Route('/{id}/modifF', name: 'app_gestion_utilisateur_modifF')]
   
    public function modifF(User $user, EntityManagerInterface $entityManager, Request $request): Response
    {
        //Création du formulaire a partir de `src/Form/ModifUserFormType`
        $form = $this->createForm(ModifUserFormType::class, $user);

        //Soumission du formulaire
        $form->handleRequest($request);

        // Verification si le formulaire est soumis et est valide
        if($form->isSubmitted() && $form->isValid())
        {
            //Envoi des changement dans la base de données
            $entityManager->flush();

            //Affichage d'un message informant de la modification du user
            $this->addFlash('info', "L'utilisateur {$user->getUsername()} a bien été modifier.");

            //Redirection vers une route valide
            return $this->redirectToRoute('app_gestion_utilisateur');

        }

        //Affichage du form dans la vue
        return $this->render('user/modifUser.html.twig',[
            "modifForm" => $form->createView()
        ]);
    }

    
    /**
     * Remove
     *
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    // Suppression de l'utilisateur
    #[Route('/{id}/remove', name: 'app_gestion_utilisateur_remove')]
    
    public function remove(User $user, EntityManagerInterface $entityManager): Response
    {
        //Affichage d'un message informant de la Suppression du user(Le message a été mis avant le flush pour pouvoir recuperer le username avant sa suppression)
        $this->addFlash('danger', "L'utilisateur {$user->getUsername()} a bien été supprimer.");

        //Envoi des changement dans la base de données
        $entityManager->remove($user);
        $entityManager->flush();

        //Redirection vers une route valide
        return $this->redirectToRoute('app_gestion_utilisateur');
    }

}

