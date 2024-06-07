<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\PartnerCategory;
use App\Repository\PartnerCategoryRepository;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PartnerCategoryType;
use App\Service\JsonResponseNormalizer;

class PartnerCategoryController extends AbstractController
{

    use UserInfoTrait;

    #[Route('admin/partner/category', name: 'app_admin_partner_category')]
    public function index(Security $security, PartnerCategoryRepository $partnerCategoryRepository): Response
    {

        $user = $this->getUserInfo($security);

        $categories = $partnerCategoryRepository->findAll();

        return $this->render('partner_category/index.html.twig', [
            'controller_name' => 'PartnerCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'categories' => $categories,
        ]);
    }

    #[Route('admin/partner/category/new', name: 'app_admin_partner_category_new')]

    public function add(Security $security, EntityManagerInterface $entityManager, Request $request): Response
    {



        $category = new PartnerCategory();

        $form = $this->createForm(PartnerCategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_partner_category');
        }

        $user = $this->getUserInfo($security);

        return $this->render('partner_category/add.html.twig', [
            'controller_name' => 'PartnerCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);

    }

    #[Route('admin/partner/category/delete/{id}', name: 'app_admin_partner_category_delete')]

    public function delete(Security $security, EntityManagerInterface $entityManager, PartnerCategory $partnerCategory): Response
    {


        $entityManager->remove($partnerCategory);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_partner_category');

    }

    #[Route('admin/partner/category/edit/{id}', name: 'app_admin_partner_category_edit')]

    public function edit(Security $security, EntityManagerInterface $entityManager, Request $request, PartnerCategory $partnerCategory): Response
    {

        $form = $this->createForm(PartnerCategoryType::class, $partnerCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($partnerCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_partner_category');
        }

        $user = $this->getUserInfo($security);

        return $this->render('partner_category/edit.html.twig', [
            'controller_name' => 'PartnerCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);

    }


    //Route publique pour obtenir toutes les catégories de partenaires sous format JSON triées par ordre alphabétique 

    #[Route('api/public/partner/category', name: 'app_public_partner_category')]

    public function publicIndex(PartnerCategoryRepository $partnerCategoryRepository, JsonResponseNormalizer $jsonResponseNormalizer): Response
    {

        $categories = $partnerCategoryRepository->findBy([], ['category' => 'ASC']);

        $categoriesArray = [];

        foreach ($categories as $category) {
            $categoriesArray[] = [
                'id' => $category->getId(),
                'category' => $category->getCategory(),
            ];
        }

      $response = $jsonResponseNormalizer->respondSuccess(200, $categoriesArray);

        return $response;
        

   

    }

    







}
