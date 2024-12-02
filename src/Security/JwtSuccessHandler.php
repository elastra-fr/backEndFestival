<?php
namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;

class JwtSuccessHandler
{
    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();
        $token = $data['token'];  // Récupérer le token JWT généré

        $response = $event->getResponse();

        // Créer le cookie avec le token JWT
        $cookie = new Cookie(
            'access_token',             // Nom du cookie
            $token,                     // Valeur (le token JWT)
            time() + 3600,              // Expiration (1 heure)
            '/',                        // Path (accessible sur tout le site)
            null,                       // Domaine (null = domaine courant)
            $_ENV['APP_ENV'] === 'prod', // Sécurisé uniquement en production
            true,                       // HttpOnly (accessible uniquement par HTTP, pas JavaScript)
            false,                      // SameSite (ajustez selon vos besoins)
        );

        $response->headers->setCookie($cookie);

        // Facultatif : Supprimer le token de la réponse JSON si non nécessaire
        unset($data['token']);
        $event->setData($data);
    }
}
