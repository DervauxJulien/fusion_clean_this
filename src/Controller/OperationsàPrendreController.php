<?php

namespace App\Controller;

use App\Repository\OperationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OperationsàPrendreController extends AbstractController
{
    #[Route('/operations/prendre/', name: 'app_operations_prendre', methods: ['GET'])]
    public function index(OperationRepository $operationRepository): Response
    {
        $stockOperation = $operationRepository->findAll();
        return $this->render('operationsàprendre/index.html.twig', [
            'operations' => $stockOperation,
        ]);
    }

    #[Route('/operation/filter/{status}', name: 'app_operation_filter', methods: ['GET'])]
    public function filterByStatus(OperationRepository $operationRepository, string $status): Response
    {
        $operations = $operationRepository->findByStatus($status);
        return $this->render('operationsàprendre/filter.html.twig', [
            'operations' => $operations,
            'getUrlStatus' => $status,
        ]);
    }

    #[Route('/operation/filter/search/{status}', name: 'app_operation_filter_query', methods: ['GET'])]
    public function findOneByClientName(OperationRepository $operationRepository, string $status, HttpFoundationRequest $request): Response
    {
        $query = $request->query->get('query', '');
        $operations = $operationRepository->findByStatus($status);

        $operationsSearch = [];

        if ($query !== null && $query !== '') {
            $operationsSearch = $operationRepository->findOneByClientName($query);
        }

        return $this->render('operationsàprendre/search.html.twig', [
            'operations' => $operations,
            'getUrlStatus' => $status,
            'operationsSearch' => $operationsSearch,
            'query' => $query,
        ]);
    }
}
