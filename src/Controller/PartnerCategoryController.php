<?php

namespace App\Controller;

use App\Entity\PartnerCategory;
use App\Form\PartnerCategoryType;
use App\Repository\PartnerCategoryRepository;
use App\Service\JsonResponseNormalizer;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PartnerCategoryController extends AbstractController
{

    use UserInfoTrait;

    /**
     * Affiche la liste des catégories de partenaires
     * Le contrôleur permet de gérer l'affichage de la liste des catégories de partenaires
     * 
     * @param Security $security
     * @param PartnerCategoryRepository $partnerCategoryRepository
     * @return Response
     * 
     */

    #[Route('admin/partner/category', name: 'app_admin_partner_category')]
    public function index(
        Security $security,
        PartnerCategoryRepository $partnerCategoryRepository
    ): Response {

        $user = $this->getUserInfo($security);

        $categories = $partnerCategoryRepository->findBy([], ['partnerCategoryName' => 'ASC']);
        dump($categories);

        return $this->render('partner_category/partner-category-index.html.twig', [
            'controller_name' => 'PartnerCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'categories' => $categories,
        ]);
    }


    /**
     * Route pour créer une nouvelle catégorie de partenaires
     * Le contrôleur permet de gérer l'ajout d'une catégorie de partenaires via un formulaire
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     * 
     */

    #[Route('admin/partner/category/new', name: 'app_admin_partner_category_new')]

    public function add(
        Security $security,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {

        $category = new PartnerCategory();

        $form = $this->createForm(PartnerCategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_partner_category');
        }

        $user = $this->getUserInfo($security);

        return $this->render('partner_category/partner-category-add.html.twig', [
            'controller_name' => 'PartnerCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }

    /**
     * Route pour supprimer une catégorie de partenaires
     * Le contrôleur permet de gérer la suppression d'une catégorie de partenaires
     * 
     * @param EntityManagerInterface $entityManager
     * @param PartnerCategory $partnerCategory
     * @return Response
     */

    #[Route('admin/partner/category/delete/{id}', name: 'app_admin_partner_category_delete')]

    public function delete(
        EntityManagerInterface $entityManager,
        PartnerCategory $partnerCategory
    ): Response {

        try {
            $entityManager->remove($partnerCategory);
            $entityManager->flush();
        } catch (\Exception $e) {

            $this->addFlash('danger', 'Impossible de supprimer cette catégorie de partenaires, elle est utilisée dans un ou plusieurs partenaires.');
        }

        return $this->redirectToRoute('app_admin_partner_category');
    }


    /**
     * Route pour éditer une catégorie de partenaires
     * Le contrôleur permet de gérer l'édition d'une catégorie de partenaires via un formulaire
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param PartnerCategory $partnerCategory
     * @return Response
     * 
     */
    #[Route('admin/partner/category/edit/{id}', name: 'app_admin_partner_category_edit')]

    public function edit(
        Security $security,
        EntityManagerInterface $entityManager,
        Request $request,
        PartnerCategory $partnerCategory
    ): Response {

        $form = $this->createForm(PartnerCategoryType::class, $partnerCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($partnerCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_partner_category');
        }

        $user = $this->getUserInfo($security);

        return $this->render('partner_category/partner-category-edit.html.twig', [
            'controller_name' => 'PartnerCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }


    /**
     * Route publique pour retourner la liste des catégories de partenaires
     * au format JSON
     * 
     * @param PartnerCategoryRepository $partnerCategoryRepository
     * @param JsonResponseNormalizer $jsonResponseNormalizer
     * @return Response
     *  
     */

    #[Route('api/public/partner/category', name: 'app_public_partner_category')]

    public function publicIndex(
        PartnerCategoryRepository $partnerCategoryRepository,
        JsonResponseNormalizer $jsonResponseNormalizer
    ): Response {

        $categories = $partnerCategoryRepository->findBy([], ['partnerCategoryName' => 'ASC']);

        $categoriesArray = [];

        foreach ($categories as $category) {
            $categoriesArray[] = [
                'id' => $category->getPartnerCategoryId(),
                'category' => $category->getPartnerCategoryName(),
            ];
        }

        $response = $jsonResponseNormalizer->respondSuccess(200, $categoriesArray);

        return $response;
    }
}
