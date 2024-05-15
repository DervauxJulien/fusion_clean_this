<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
// use Symfony\Component\HttpFoundation\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\OperationRepository;




class MailController extends AbstractController
{
    #[Route('/generate-pdf-and-send-email/{id}', name: 'app_generate_pdf_and_send_email')]
    public function generatePdfAndSendEmail($id, MailerInterface $mailer, OperationRepository $operationRepository): Response
    {
        // Récupérer l'opération depuis la base de données
        $operation = $operationRepository->find($id);

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

        // Récupérer le nom du client
        $clientName = $operation->getClient()->getNom();

        // Remplacer les caractères spéciaux dans le nom du client
        $clientName = str_replace([' ', '/'], '_', $clientName);

        // Construire le nom du fichier PDF avec le nom du client
        $fileName = $clientName . '_facture.pdf';

        // Envoyer le PDF par e-mail
        $email = (new Email())
        ->from('contactcleanthis@gmail.com')
        ->to('franck.lamyformationafpa@gmail.com')
        // ->cc('franck.lamyformationafpa@gmail.com')
        ->subject('Votre facture')
        ->text('Voici ci-joint votre facture relatif à la prestaiton de nettoyage. A bientôt avec CleanThis')
        ->attach($dompdf->output(), $fileName, 'application/pdf');

        // Envoyer l'e-mail
        $mailer->send($email);


        // Retourner une réponse
        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);



    }
}
