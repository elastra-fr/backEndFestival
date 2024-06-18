<?php

namespace App\Controller;

use App\Entity\NewsCategory;
use App\Form\NewsCategoryType;
use App\Repository\NewsCategoryRepository;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsCategoryController extends AbstractController
{
    use UserInfoTrait;



    /**
     * Affiche la liste des catégories de news
     * Le contrôleur permet de gérer l'affichage de la liste des catégories de news
     * 
     *
     * @param Security $security
     * @param NewsCategoryRepository $newsCategoryRepository
     * @return Response
     */
    #[Route('admin/news/category', name: 'app_admin_news_category')]
    public function index(
        Security $security,
        NewsCategoryRepository $newsCategoryRepository
    ): Response {

        $user = $this->getUserInfo($security);

        $categories = $newsCategoryRepository->findBy([], ['Category' => 'ASC']);

        return $this->render('news_category/news-category-index.html.twig', [
            'controller_name' => 'NewsCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'categories' => $categories,
        ]);
    }

    /**
     * Route pour créer une nouvelle catégorie de news
     * Le contrôleur permet de gérer l'ajout d'une catégorie de news via un formulaire
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */

    #[Route('admin/news/category/new', name: 'app_admin_news_category_new')]

    public function add(
        Security $security,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {

        $newsCategory = new NewsCategory();

        $form = $this->createForm(NewsCategoryType::class, $newsCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($newsCategory);

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_news_category');
        }

        $user = $this->getUserInfo($security);

        return $this->render('news_category/news-category-add.html.twig', [
            'controller_name' => 'NewsCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }


    /**
     * Route pour supprimer une catégorie de news
     * Le contrôleur permet de gérer la suppression d'une catégorie de news via un formulaire
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param NewsCategory $newsCategory
     * @return Response
     */

    #[Route('admin/news/category/delete/{id}', name: 'app_admin_news_category_delete')]

    public function delete(
        EntityManagerInterface $entityManager,
        NewsCategory $newsCategory
    ): Response {

        try {
            $entityManager->remove($newsCategory);
            $entityManager->flush();
        } catch (\Exception $e) {

            $this->addFlash('danger', 'Impossible de supprimer cette catégorie de news, elle est utilisée dans une ou plusieurs news.');
        }


        return $this->redirectToRoute('app_admin_news_category');
    }

    /**
     * Route pour éditer une catégorie de news
     * Le contrôleur permet de gérer l'édition d'une catégorie de news via un formulaire
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param NewsCategory $newsCategory
     * @return Response
     */

    #[Route('admin/news/category/edit/{id}', name: 'app_admin_news_category_edit')]

    public function edit(
        Security $security,
        EntityManagerInterface $entityManager,
        Request $request,
        NewsCategory $newsCategory
    ): Response {
        $form = $this->createForm(NewsCategoryType::class, $newsCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($newsCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_news_category');
        }

        $user = $this->getUserInfo($security);

        return $this->render('news_category/news-category-add.html.twig', [
            'controller_name' => 'NewsCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }
}
