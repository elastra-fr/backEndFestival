<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Trait\UserInfoTrait;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Stage;
use App\Repository\StageRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\StageType;


class StageController extends AbstractController
{

    use UserInfoTrait;
    #[Route('/admin/concert/stage', name: 'app_admin_stage')]
    public function index(Security $security, StageRepository $stageRepository): Response
    {

        $user = $this->getUserInfo($security);

        $stages= $stageRepository->findAll();

        return $this->render('stage/index.html.twig', [
            'controller_name' => 'StageController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'stages' => $stages,
            

        ]);
    }

    #[Route('/admin/concert/stage/new', name: 'app_admin_stage_new')]

    public function add(Security $security, EntityManagerInterface $entityManager,  Request $request): Response
    {

        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stage);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_stage');
        }

        $user = $this->getUserInfo($security);

        return $this->render('stage/add.html.twig', [
            'controller_name' => 'StageController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/concert/stage/edit/{id}', name: 'app_admin_stage_edit')]

    public function edit(Security $security, EntityManagerInterface $entityManager, Stage $stage, Request $request): Response
    {

        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stage);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_stage');
        }

        $user = $this->getUserInfo($security);

        return $this->render('stage/edit.html.twig', [
            'controller_name' => 'StageController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/concert/stage/delete/{id}', name: 'app_admin_stage_delete')]

    public function delete(Security $security, EntityManagerInterface $entityManager, Stage $stage): Response
    {

        $entityManager->remove($stage);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_stage');
    }



}
