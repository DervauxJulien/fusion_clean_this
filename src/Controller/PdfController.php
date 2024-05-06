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
        // Récupérer toutes les opérations
    $operations = $this->operationRepository->findAll();

        return $this->render('pdf/index.html.twig', [
            'controller_name' => 'PdfController',
            'operations'=>$operations,
        ]);
    }

#[Route('/generate-pdf/{id}', name: 'app_generate_pdf')]
public function generatePdfAction($id): Response
{
    // Récupérer l'opération depuis la base de données
    $operation = $this->operationRepository->find($id);

    // Vérifier si l'opération existe
    if (!$operation) {
        throw $this->createNotFoundException('Opération non trouvée');
    }

    // Créer une instance de Dompdf avec les options
    $pdfOptions = new Options();

    // Instancier Dompdf avec les options
    $dompdf = new Dompdf($pdfOptions);

    // Générer le contenu HTML de la facture
    $html = $this->renderView('pdf/invoice.html.twig', [
        'operation' => $operation,
    ]);

      // Récupérer le nom du client
      $clientName = $operation->getClient()->getNom();

    // Charger le contenu HTML dans Dompdf
    $dompdf->loadHtml($html);

    // Rendre le contenu en PDF
    $dompdf->render();

    // Remplacer les caractères spéciaux dans le nom du client
     $clientName = str_replace([' ', '/'], '_', $clientName);

    // Construire le nom du fichier PDF avec le nom du client
     $fileName = $clientName . '_facture.pdf';

    // Envoyer le PDF en réponse
    return new Response($dompdf->output(), Response::HTTP_OK, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="Facture_CleanThis_' . $clientName . '.pdf"',
    ]);
}
}
