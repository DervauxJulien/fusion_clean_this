<?php

namespace App\Controller;

use App\Repository\OperationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MesOperationController extends AbstractController
{
    #[Route('apprenti/mes/operation', name: 'app_mes_operationA')]
    public function indexA(OperationRepository $operationRepository): Response
    {
        return $this->render('mes_operation/index.html.twig', [
            'MyOps' => $operationRepository->findAll(),
        ]);
    }

    #[Route('senior/mes/operation', name: 'app_mes_operationS')]
    public function indexS(OperationRepository $operationRepository): Response
    {
        return $this->render('mes_operation/index.html.twig', [
            'MyOps' => $operationRepository->findAll(),
        ]);
    }

    #[Route('admin/mes/operation', name: 'app_mes_operationE')]
    public function index(OperationRepository $operationRepository): Response
    {
        return $this->render('mes_operation/index.html.twig', [
            'MyOps' => $operationRepository->findAll(),
        ]);
    }

    #[Route('/admin/mes/operation/terminer/{id}', name: 'app_operation_terminerE')]
    public function terminerOperationE(OperationRepository $operationRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $operation = $operationRepository->find($id);
        $operation->setStatus('Terminer');

        $entityManager->flush();

        return $this->redirectToRoute('app_mes_operationE');
    }

    #[Route('/senior/mes/operation/terminer/{id}', name: 'app_operation_terminerS')]
    public function terminerOperationS(OperationRepository $operationRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $operation = $operationRepository->find($id);
        $operation->setStatus('Terminer');

        $entityManager->flush();

        return $this->redirectToRoute('app_mes_operationS');
    }

    #[Route('/apprenti/mes/operation/terminer/{id}', name: 'app_operation_terminerA')]
    public function terminerOperationA(OperationRepository $operationRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $operation = $operationRepository->find($id);
        $operation->setStatus('Terminer');

        $entityManager->flush();

        return $this->redirectToRoute('app_mes_operationA');
    }
}
