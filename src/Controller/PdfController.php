<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\OperationRepository;

class PdfController extends AbstractController
{
    private $operationRepository;

    public function __construct(OperationRepository $operationRepository)
    {
        $this->operationRepository = $operationRepository;
    }

    #[Route('/pdf', name: 'app_pdf')]
    public function index(): Response
    {
        return $this->render('pdf/index.html.twig', [
            'controller_name' => 'PdfController',
        ]);
    }

    #[Route('/generate-pdf/{id}', name: 'app_generate_pdf')]
    public function generatePdfAction($id): Response
    {
        // Récupérer l'opération depuis la base de données
        $operation = $this->operationRepository->find($id);

        // Créer une instance de Dompdf avec les options
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instancier Dompdf avec les options
        $dompdf = new Dompdf($pdfOptions);

        // Générer le contenu HTML de la facture
        $html = $this->renderView('pdf/invoice.html.twig', [
            'operation' => $operation,
        ]);

        // Charger le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Rendre le contenu en PDF
        $dompdf->render();

        // Envoyer le PDF en réponse
        return new Response($dompdf->output(), Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
