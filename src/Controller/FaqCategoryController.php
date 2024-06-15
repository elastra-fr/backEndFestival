<?php

namespace App\Controller;

use App\Entity\FaqCategory;
use App\Form\FaqCategoryType;
use App\Repository\FaqCategoryRepository;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FaqCategoryController extends AbstractController
{
    use UserInfoTrait;

/**
 * Route pour afficher la liste des catégories de la FAQ via le template index.html.twig
 * 
 * @param Security $security
 * @param FaqCategoryRepository $faqCategoryRepository
 * @return Response
 */

    #[Route('/admin/faq/category', name: 'app_admin_faq_category')]
    public function index(Security $security, 
    FaqCategoryRepository $faqCategoryRepository): Response
    {

        $user = $this->getUserInfo($security);

        $categories= $faqCategoryRepository->findAll();

        return $this->render('faq_category/index.html.twig', [
            'controller_name' => 'FaqCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'categories' => $categories,
        ]);

    }

    /**
     * Route pour ajouter une catégorie de la FAQ via le template add.html.twig
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */


    #[Route('/admin/faq/category/new', name: 'app_admin_faq_category_new')] 

    public function add(Security $security, 
    EntityManagerInterface $entityManager, 
    Request $request): Response
    {

            $faqCategory = new FaqCategory();

            $form = $this->createForm(FaqCategoryType::class, $faqCategory);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) { 
                $entityManager->persist($faqCategory);
                $entityManager->flush();

                return $this->redirectToRoute('app_admin_faq_category');
            }

            $user = $this->getUserInfo($security);

            return $this->render('faq_category/add.html.twig', [
                'controller_name' => 'FaqCategoryController',
                'firstName' => $user['firstName'],
                'role' => $user['role'],
                'form' => $form->createView(),
            ]);

     
    }


/**
 * Route pour supprimer une catégorie de la FAQ
 * 
 * @param EntityManagerInterface $entityManager
 * @param FaqCategory $faqCategory
 * @return Response
 */

    #[Route('/admin/faq/category/delete/{id}', name: 'app_admin_faq_category_delete')]

    public function delete(EntityManagerInterface $entityManager, 
    FaqCategory $faqCategory): Response
    {

        $entityManager->remove($faqCategory);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_faq_category');

    }

    /**
     * Route pour modifier une catégorie de la FAQ via le template edit.html.twig
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param FaqCategory $faqCategory
     * @param Request $request
     * @return Response
     * 
     */

    #[Route('/admin/faq/category/edit/{id}', name: 'app_admin_faq_category_edit')]

    public function edit(Security $security, 
    EntityManagerInterface $entityManager, 
    FaqCategory $faqCategory, 
    Request $request): Response
    {

        $form = $this->createForm(FaqCategoryType::class, $faqCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager->persist($faqCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_faq_category');
        }

        $user = $this->getUserInfo($security);

        return $this->render('faq_category/edit.html.twig', [
            'controller_name' => 'FaqCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);

    }




}
