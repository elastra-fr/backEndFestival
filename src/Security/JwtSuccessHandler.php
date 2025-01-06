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

        // Crée le cookie avec SameSite='None' et les autres paramètres
        $cookie = Cookie::create(
            'access_token',  // Nom du cookie
            $token,          // Valeur (le token JWT)
        )
        ->withExpires(time() + 3600)    // Expiration (1 heure)
        ->withPath('/')                // Path (accessible sur tout le site)
        ->withSecure(true)             // Secure (en production HTTPS)
        ->withHttpOnly(true)           // HttpOnly (accessible uniquement par HTTP, pas JavaScript)
        ->withSameSite('None');        // SameSite pour les cookies cross-origin

        // Ajoute le cookie dans les en-têtes de la réponse
        $response->headers->setCookie($cookie);

        // Facultatif : Supprimer le token de la réponse JSON si non nécessaire
        unset($data['token']);
        $event->setData($data);
    }
}
