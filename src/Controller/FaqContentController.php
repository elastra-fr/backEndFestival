<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FaqContentController extends AbstractController
{
    #[Route('/faq/content', name: 'app_faq_content')]
    public function index(): Response
    {
        return $this->render('faq_content/index.html.twig', [
            'controller_name' => 'FaqContentController',
        ]);
    }
}
