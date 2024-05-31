<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PartnerCategoryController extends AbstractController
{
    #[Route('/partner/category', name: 'app_partner_category')]
    public function index(): Response
    {
        return $this->render('partner_category/index.html.twig', [
            'controller_name' => 'PartnerCategoryController',
        ]);
    }
}
