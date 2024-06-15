<?php

namespace App\Controller;

use App\Trait\UserInfoTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class HomeController extends AbstractController
{

       use UserInfoTrait;


/**
 * Affiche la page d'accueil de l'admin avec les informations de l'utilisateur connecté (prénom et rôle)
 * et le menu de navigation pour accéder aux différentes fonctionnalités de l'application
 *
 * @param Security $security
 * @return Response
 */
#[Route('/admin/home', name: 'app_admin_home')]

    public function index(Security $security): Response
    {

        $userInfo = $this->getUserInfo($security);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'firstName' => $userInfo['firstName'],
            'role' => $userInfo['role']
        ]);
     

    }
}
