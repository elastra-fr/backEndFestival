<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MusicStyleController extends AbstractController
{
    #[Route('/music/style', name: 'app_music_style')]
    public function index(): Response
    {
        return $this->render('music_style/index.html.twig', [
            'controller_name' => 'MusicStyleController',
        ]);
    }
}
