<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Trait\UserInfoTrait;
use Symfony\Bundle\SecurityBundle\Security;

class BandController extends AbstractController
{
    use UserInfoTrait;
    #[Route('/admin/band', name: 'app_admin_band')]
    public function index(Security $security): Response
    {
        $user = $this->getUserInfo($security);
        return $this->render('band/index.html.twig', [
            'controller_name' => 'BandController',
            'firstName' => $user['firstName'],
            'role' => $user['role']
        ]);
    }
}
