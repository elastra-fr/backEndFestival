<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Trait\UserInfoTrait;
use Symfony\Bundle\SecurityBundle\Security;


class StageController extends AbstractController
{

    use UserInfoTrait;
    #[Route('/admin/concert/stage', name: 'app_admin_stage')]
    public function index(Security $security): Response
    {

        $user = $this->getUserInfo($security);

        return $this->render('stage/index.html.twig', [
            'controller_name' => 'StageController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'stages' => 'stages',
            

        ]);
    }
}
