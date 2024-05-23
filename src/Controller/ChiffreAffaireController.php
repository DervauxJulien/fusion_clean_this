<?php
/**ChiffreAffaire */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


#[Route('/admin/chiffre/affaire')]
class ChiffreAffaireController extends AbstractController
{
    #[Route('/', name: 'app_chiffre_affaire')]
    public function index(): Response
    {
        $progress = 30;
        $chiffreAnnee = 12500;
        $chiffreMois = 6250;

        
        return $this->render('chiffre_affaire/index.html.twig', [
            'controller_name' => 'ChiffreAffaireController',
            'progress' => $progress,
            'chiffreAnne'=> $chiffreAnnee,
            'chiffreMois' => $chiffreMois,

        ]);
    }
}
