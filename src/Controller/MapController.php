<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Trait\UserInfoTrait;
use Symfony\Bundle\SecurityBundle\Security;

class MapController extends AbstractController
{

    use UserInfoTrait;
    #[Route('/admin/map', name: 'app_admin_map')]
    public function index(Security $security): Response
    {

        $user = $this->getUserInfo($security);
        return $this->render('map/index.html.twig', [
            'controller_name' => 'MapController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],


        ]);
    }
}
