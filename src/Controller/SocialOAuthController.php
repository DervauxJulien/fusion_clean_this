<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route as AttributeRoute;

class SocialOAuthController extends AbstractController
{
    private const SCOPES = [
        'google' => []
    ];
    private ClientRegistry $clientRegistry;

    public function __construct(ClientRegistry $clientRegistry)
    {
        $this->clientRegistry = $clientRegistry;
    }
    #[AttributeRoute('/oauth/service/google', name: 'app_oauth')]
    public function authLogin()
    {
        /**
         * @var GoogleUser $client
         */

        $client = $this->clientRegistry->getClient('google');
        return $client->redirect(['read:user', 'user:email']);
    }

    #[AttributeRoute('/oauth/check/google', name: 'oauth_check')]
    public function check()
    {
        return new Response();
        
    }
}
