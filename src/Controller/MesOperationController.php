<?php

namespace App\Controller;

use App\Repository\OperationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class MesOperationController extends AbstractController
{
    //Route pour la page 'Mes opérations' spécifique au Rôle

    #[Route('apprenti/mes/operation', name: 'app_mes_operationA')]
    //Route spécifique pour le rôle Apprenti
    public function indexA(OperationRepository $operationRepository): Response
    {
        return $this->render('mes_operation/index.html.twig', [
            'MyOps' => $operationRepository->findAll(),
        ]);
    }

    #[Route('senior/mes/operation', name: 'app_mes_operationS')]
    //Route spécifique pour le rôle Senior
    public function indexS(OperationRepository $operationRepository): Response
    {
        return $this->render('mes_operation/index.html.twig', [
            'MyOps' => $operationRepository->findAll(),
        ]);
    }

    #[Route('admin/mes/operation', name: 'app_mes_operationE')]
    //Route spécifique pour le rôle Expert
    public function index(OperationRepository $operationRepository): Response
    {
        return $this->render('mes_operation/index.html.twig', [
            'MyOps' => $operationRepository->findAll(),
        ]);
    }

    //Route permettant de "terminer" une opération selon le roles

    #[Route('/admin/mes/operation/terminer/{id}', name: 'app_operation_terminerE')]
    //Terminer une opération pour le rôle Expert
    public function terminerOperationE(OperationRepository $operationRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        //Recuperation de l'operation en fonction de l'id
        $operation = $operationRepository->find($id);

        // Changement du status de l'operation
        $operation->setStatus('Terminer');

        //Ajout de la date lorsque le status change
        $operation->setDateFin(new \DateTime());

        $entityManager->flush();

        $this->addFlash('info', "L'operation de {$operation->getClient()} a bien été terminer");

        //Redirection vers une route valide
        return $this->redirectToRoute('app_mes_operationE');
    }

    #[Route('/senior/mes/operation/terminer/{id}', name: 'app_operation_terminerS')]
    //Terminer une opération pour le rôle Senior
    public function terminerOperationS(OperationRepository $operationRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        //Recuperation de l'operation en fonction de l'id
        $operation = $operationRepository->find($id);

        // Changement du status de l'operation
        $operation->setStatus('Terminer');

        //Ajout de la date lorsque le status change
        $operation->setDateFin(new \DateTime());

        $entityManager->flush();

        $this->addFlash('info', "L'operation de {$operation->getClient()} a bien été terminer");

        //Redirection vers une route valide
        return $this->redirectToRoute('app_mes_operationS');        
    }

    #[Route('/apprenti/mes/operation/terminer/{id}', name: 'app_operation_terminerA')]
    //Terminer une opération pour le rôle Apprenti
    public function terminerOperationA(OperationRepository $operationRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        //Recuperation de l'operation en fonction de l'id
        $operation = $operationRepository->find($id);
        
        // Changement du status de l'operation
        $operation->setStatus('Terminer');

        //Ajout de la date lorsque le status change
        $operation->setDateFin(new \DateTime());

        $entityManager->flush();

        $this->addFlash('info', "L'operation de {$operation->getClient()} a bien été terminer");

        //Redirection vers une route valide
        return $this->redirectToRoute('app_mes_operationA');
    }
}
