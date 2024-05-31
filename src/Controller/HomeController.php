<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Trait\UserInfoTrait;


class HomeController extends AbstractController
{

       use UserInfoTrait;

#[Route('/admin/home', name: 'app_admin_home')]

    public function index(Security $security): Response
    {

        $userInfo = $this->getUserInfo($security);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'firstName' => $userInfo['firstName'],
            'role' => $userInfo['role']
        ]);
     
/*
        $user = $security->getUser();   

        if($user){
           $firstName = $user->getFirstName();
            $role = $user->getRoles()[0];
        }

*/


        

/*

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'firstName' => $firstName,
            'role' => $role

        ]);*/
    }
}
