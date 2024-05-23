<?php
// src/Controller/LanguageController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LanguageController extends AbstractController
{
    #[Route('/change-language/{locale}', name: 'change_language')]
    public function changeLanguage(string $locale, Request $request): RedirectResponse
    {
        // Stocker la langue choisie dans la session
        $request->getSession()->set('_locale', $locale);

        // Rediriger vers la page précédente
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer ?: $this->generateUrl('homepage'));
    }
}
