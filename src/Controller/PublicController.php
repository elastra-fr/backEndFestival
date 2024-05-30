<?php

namespace App\Controller;

use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PublicController extends AbstractController
{
    #[Route('/api/public', name: 'app_public', methods: ['GET'])]
    public function index(): JsonResponse   
    {
       /* return $this->render('public/index.html.twig', [
            'controller_name' => 'PublicController',
        ]);*/
        return new JsonResponse(['message' => 'Bienvenue sur la page public']);
    }


/******Teste le routes protégées JWT */


#[Route('/api/user', name: 'app_private_user', methods: ['GET'])]

public function private(): JsonResponse
{
    return new JsonResponse(['message' => 'Ceci est une route protégée']);
}

#[Route('/admin/user', name: 'app_admin_user', methods: ['GET'])]



public function admin(): JsonResponse
{
    return new JsonResponse(['message' => 'Ceci est une route protégée pour les admins']);


}

}