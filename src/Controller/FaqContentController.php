<?php

namespace App\Controller;

use App\Entity\FaqContent;
use App\Form\FaqContentType;
use App\Repository\FaqCategoryRepository;
use App\Repository\FaqContentRepository;
use App\Service\JsonResponseNormalizer;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FaqContentController extends AbstractController
{
    use UserInfoTrait;


    /**
     * Affiche la liste des contenus de FAQ
     * Le contrôleur permet de gérer l'affichage de la liste des contenus de FAQ
     * 
     * @param Security $security
     * @param FaqContentRepository $faqContentRepository
     * @param FaqCategoryRepository $faqCategoryRepository
     * @param Request $request
     * @return Response
     */

    #[Route('admin/faq/', name: 'app_admin_faq_content')]
    public function index(
        Security $security,
        FaqContentRepository $faqContentRepository,
        FaqCategoryRepository $faqCategoryRepository,
        Request $request
    ): Response {

        $user = $this->getUserInfo($security);


        $sectionFilter = $request->query->get('sectionId');

        $sections = $faqCategoryRepository->findBy([], ['category' => 'ASC']);


        if ($sectionFilter) {

            $contents = $faqContentRepository->findBy(['section' => $sectionFilter]);
        } else {
            $contents = $faqContentRepository->findAll();
        }


        return $this->render('faq_content/faq-content-index.html.twig', [
            'controller_name' => 'FaqContentController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'contents' => $contents,
            'sections' => $sections,
            'sectionFilter' => $sectionFilter,
        ]);
    }

    /**
     * Route pour créer un nouveau contenu de FAQ
     * Le contrôleur permet de gérer l'ajout d'un contenu de FAQ via un formulaire
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     * 
     */

    #[Route('admin/faq/content/new', name: 'app_admin_faq_content_new')]

    public function add(
        Security $security,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $faqContent = new FaqContent();

        $form = $this->createForm(FaqContentType::class, $faqContent);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $faqContent->setContentUpdate(new \DateTime('now'));

            $entityManager->persist($faqContent);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_faq_content');
        }

        $user = $this->getUserInfo($security);

        return $this->render('faq_content/faq-content-add.html.twig', [
            'controller_name' => 'FaqContentController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }

    /**
     * Route pour supprimer un contenu de FAQ
     * Le contrôleur permet de gérer la suppression d'un contenu de FAQ
     * 
     * @param EntityManagerInterface $entityManager
     * @param FaqContent $faqContent
     * @return Response
     * 
     */

    #[Route('admin/faq/content/delete/{id}', name: 'app_admin_faq_content_delete')]

    public function delete(
        EntityManagerInterface $entityManager,
        FaqContent $faqContent
    ): Response {
        $entityManager->remove($faqContent);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_faq_content');
    }

    /**
     * Route pour éditer un contenu de FAQ
     * Le contrôleur permet de gérer l'édition d'un contenu de FAQ via un formulaire
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param FaqContent $faqContent
     * @return Response
     * 
     */

    #[Route('admin/faq/content/edit/{id}', name: 'app_admin_faq_content_edit')]

    public function edit(
        Security $security,
        EntityManagerInterface $entityManager,
        Request $request,
        FaqContent $faqContent
    ): Response {
        $form = $this->createForm(FaqContentType::class, $faqContent);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $faqContent->setContentUpdate(new \DateTime('now'));
            $entityManager->persist($faqContent);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_faq_content');
        }

        $user = $this->getUserInfo($security);

        return $this->render('faq_content/faq-content-add.html.twig', [
            'controller_name' => 'FaqContentController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }

    /**
     * Route pour retourner les contenus de FAQ en JSON
     * 
     * @param FaqCategoryRepository $faqCategoryRepository
     * @param JsonResponseNormalizer $jsonResponseNormalizer
     * @return JsonResponse
     * 
     */

    #[Route('/api/public/faq', name: 'app_faq_content', methods: ['GET'])]

    public function faqContent(
        FaqCategoryRepository $faqCategoryRepository,
        JsonResponseNormalizer $jsonResponseNormalizer
    ): JsonResponse {


        $categories = $faqCategoryRepository->findAll();

        $response = [];


        foreach ($categories as $category) {

            $contents = $category->getFaqContents();

            $categoryData = [
                'category' => $category->getCategory(),
                'contents' => [],
            ];


            foreach ($contents as $content) {
                $categoryData['contents'][] = [
                    'id' => $content->getId(),
                    'title' => $content->getTitle(),
                    'content' => $content->getContent(),
                    'contentUpdate' => $content->getContentUpdate(),
                ];
            }


            if (count($categoryData['contents']) > 0) {
                $response[] = $categoryData;
            }
        }

        $allFaqContentResponse = $jsonResponseNormalizer->respondSuccess(200, $response);
        return $allFaqContentResponse;
    }
}
