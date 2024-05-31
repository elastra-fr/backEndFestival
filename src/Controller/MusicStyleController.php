<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Trait\UserInfoTrait;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\MusicStyle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MusicStyleType;
use App\Repository\MusicStyleRepository;

class MusicStyleController extends AbstractController
{
    use UserInfoTrait;
    #[Route('/admin/band/style', name: 'app_admin_style')]
    public function index(Security $security, MusicStyleRepository $musicStyleRepository): Response
    {

        $user = $this->getUserInfo($security);

        $styles= $musicStyleRepository->findAll();




        return $this->render('music_style/index.html.twig', [
            'controller_name' => 'MusicStyleController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'styles' => $styles,
        ]);
    }


#[Route('/admin/band/style/new', name: 'app_admin_style_new')]
    public function add(Security $security, EntityManagerInterface $entityManager, Request $request): Response
    {


        $musicStyle = new MusicStyle();
        $form = $this->createForm(MusicStyleType::class, $musicStyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager->persist($musicStyle);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_style');
        }

        $user = $this->getUserInfo($security);

        return $this->render('music_style/add.html.twig', [
            'controller_name' => 'MusicStyleController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);


    }

    #[Route('/admin/band/style/delete/{id}', name: 'app_admin_style_delete')]

    public function delete(Security $security, EntityManagerInterface $entityManager, MusicStyle $musicStyle): Response
    {
        $entityManager->remove($musicStyle);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_style');
    }



}
