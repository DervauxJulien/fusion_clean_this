<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use League\OAuth2\Client\Provider\GoogleUser;

class SocialOAuthController extends AbstractController
{
    private const SCOPES = [
        'google' => ['email']
    ];
    
    private ClientRegistry $clientRegistry;
    private EntityManagerInterface $entityManager;

    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $entityManager)
    {
        $this->clientRegistry = $clientRegistry;
        $this->entityManager = $entityManager;
    }

    #[Route('/oauth/connect/google', name: 'app_oauth')]
    public function authLogin(): Response
    {
        $client = $this->clientRegistry->getClient('google');
        return $client->redirect(self::SCOPES['google']);
    }

    #[Route('/oauth/check/google', name: 'oauth_check')]
    public function check(Request $request): Response
    {
        return new Response();
    }

    #[Route('/oauth/link/google', name: 'link_google')]
    public function linkGoogle(Request $request): Response
    {
        if (!$this->getUser()) {
            throw new AuthenticationException('You must be logged in to link your Google account.');
        }

        $client = $this->clientRegistry->getClient('google');
        return $client->redirect(self::SCOPES['google']);
    }

    #[Route('/oauth/link/check/google', name: 'link_google_check')]
    public function linkGoogleCheck(Request $request): Response
    {
        if (!$this->getUser()) {
            throw new AuthenticationException('You must be logged in to link your Google account.');
        }

        $client = $this->clientRegistry->getClient('google');
        $credentials = $client->getAccessToken(); // Correction: Utilisation correcte de getAccessToken

        /** @var GoogleUser $googleUser */
        $googleUser = $client->fetchUserFromToken($credentials);

        if ($googleUser->getId() === null) {
            throw new AuthenticationException('No verified email address found.');
        }

        $user = $this->getUser();
        $user->setGoogleId($googleUser->getId());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('profile'); // Remplacez 'profile' par la route de votre choix
    }
}
