<?php

namespace App\Controller;

use App\Repository\NewsCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\NewsCategory;
use App\Form\NewsCategoryType;

class NewsCategoryController extends AbstractController
{
    use UserInfoTrait;
    #[Route('admin/news/category', name: 'app_admin_news_category')]
    
    public function index(Security $security, NewsCategoryRepository $newsCategoryRepository): Response
    {
        
        $user = $this->getUserInfo($security);

        $categories = $newsCategoryRepository->findAll();

        return $this->render('news_category/index.html.twig', [
            'controller_name' => 'NewsCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'categories' => $categories,
        ]);


    }

    #[Route('admin/news/category/new', name: 'app_admin_news_category_new')]

    public function add(Security $security, EntityManagerInterface $entityManager, Request $request): Response
    {

        $newsCategory = new NewsCategory();

        $form = $this->createForm(NewsCategoryType::class, $newsCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($newsCategory);

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_news_category');

        }

        $user = $this->getUserInfo($security);

        return $this->render('news_category/add.html.twig', [
            'controller_name' => 'NewsCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);





    }


    #[Route('admin/news/category/delete/{id}', name: 'app_admin_news_category_delete')]

    public function delete(Security $security, EntityManagerInterface $entityManager, NewsCategory $newsCategory): Response
    {
        $entityManager->remove($newsCategory);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_news_category');

    }

    #[Route('admin/news/category/edit/{id}', name: 'app_admin_news_category_edit')]

    public function edit(Security $security, EntityManagerInterface $entityManager, Request $request, NewsCategory $newsCategory): Response
    {
        $form = $this->createForm(NewsCategoryType::class, $newsCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($newsCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_news_category');

        }

        $user = $this->getUserInfo($security);

        return $this->render('news_category/add.html.twig', [
            'controller_name' => 'NewsCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);

    }



}
