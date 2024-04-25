<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateUserFormType;
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
    // Affichage des Utilisateur
    #[Route('/', name: 'app_gestion_utilisateur')]
    public function index(UserRepository $userRepository): Response
    {
        
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }


    // Creation d'un nouvel utilisateur
    #[Route('/create', name: 'app_gestion_utilisateur_create')]
    public function create(User $user, EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
       
        $form = $this->createForm(CreateUserFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_gestion_utilisateur');
        }


        return $this->render('user/create.html.twig',[
            "createForm" => $form
        ]);
    }


    // Modification du roles utilisateur vers Senior
    #[Route('/{id}/modifS', name: 'app_gestion_utilisateur_modifS')]
    public function modifS(User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setRoles(["ROLE_SENIOR"]);
        $entityManager->flush();


        return $this->redirectToRoute('app_gestion_utilisateur');
        
    }

    // Modification du roles vers Expert

    // #[Route('/{id}/modifE', name: 'app_gestion_utilisateur_modifE')]
    // public function modifE(User $user, EntityManagerInterface $entityManager): Response
    // {
    //     $user->setRoles(["ROLE_EXPERT"]);
    //     $entityManager->flush();


    //     return $this->redirectToRoute('app_gestion_utilisateur');
        
    // }

    // Modification du roles utilisateur vers Apprenti
    #[Route('/{id}/modifA', name: 'app_gestion_utilisateur_modifA')]
    public function modifA(User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setRoles([]);
        $entityManager->flush();


        return $this->redirectToRoute('app_gestion_utilisateur');
        
    }

    // Suppression de l'utilisateur
    #[Route('/{id}/remove', name: 'app_gestion_utilisateur_remove')]
    public function remove(User $user, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_gestion_utilisateur');
    }

}

