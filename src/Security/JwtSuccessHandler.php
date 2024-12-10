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

$cookie = new Cookie(
    'access_token',  // Nom du cookie
    $token,          // Valeur (le token JWT)
    time() + 3600,   // Expiration (1 heure)
    '/',             // Path (accessible sur tout le site)
    null,            // Domaine
    true,            // Secure (en production HTTPS)
    true,            // HttpOnly (accessible uniquement par HTTP, pas JavaScript)
    'None'           // SameSite (doit être 'None' pour les cookies cross-origin)
);

        $response->headers->setCookie($cookie);

        // Facultatif : Supprimer le token de la réponse JSON si non nécessaire
        unset($data['token']);
        $event->setData($data);
    }
}
