<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;
use App\Trait\UserInfoTrait;


class PartnerController extends AbstractController
{
    use UserInfoTrait;
    #[Route('/admin/partner', name: 'app_admin_partner')]
    public function index(Security $security): Response
    {

        $user=$this->getUserInfo($security);

        return $this->render('partner/index.html.twig', [
            'controller_name' => 'PartnerController',
            'firstName' => $user['firstName'],
            'role' => $user['role']
        ]);
    }
}
