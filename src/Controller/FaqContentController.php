<?php

namespace App\Controller;

use App\Repository\FaqContentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\FaqContent;
use App\Form\FaqContentType;
use App\Repository\FaqCategoryRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\JsonResponseNormalizer;

class FaqContentController extends AbstractController
{
    use UserInfoTrait;
    #[Route('admin/faq/', name: 'app_admin_faq_content')]
    public function index(Security $security, FaqContentRepository $faqContentRepository, FaqCategoryRepository $faqCategoryRepository, Request $request): Response
    {



        $user = $this->getUserInfo($security);

        //Paramètre de recherche par section

        $sectionFilter = $request->query->get('sectionId');

        //Récupération des sections pour les filtres de recherche
        $sections = $faqCategoryRepository->findAll();

        if ($sectionFilter) {

            $contents = $faqContentRepository->findBy(['section' => $sectionFilter]);
        } else {
            $contents = $faqContentRepository->findAll();
        }

        //$contents= $faqContentRepository->findAll();

        return $this->render('faq_content/index.html.twig', [
            'controller_name' => 'FaqContentController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'contents' => $contents,
            'sections' => $sections,
            'sectionFilter' => $sectionFilter,
        ]);
  

        
    }


    #[Route('admin/faq/content/new', name: 'app_admin_faq_content_new')]

    public function add(Security $security, EntityManagerInterface $entityManager, Request $request): Response
    {
$faqContent = new FaqContent();

$form=$this->createForm(FaqContentType::class, $faqContent);

$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {

    $faqContent->setContentUpdate(new \DateTime('now'));

    $entityManager->persist($faqContent);
    $entityManager->flush();

    return $this->redirectToRoute('app_admin_faq_content');


}

$user = $this->getUserInfo($security);

    return $this->render('faq_content/add.html.twig', [
        'controller_name' => 'FaqContentController',
        'firstName' => $user['firstName'],
        'role' => $user['role'],
        'form' => $form->createView(),
    ]);

    }


#[Route('admin/faq/content/delete/{id}', name: 'app_admin_faq_content_delete')]

public function delete(Security $security, EntityManagerInterface $entityManager, FaqContent $faqContent): Response
{
    $entityManager->remove($faqContent);
    $entityManager->flush();

    return $this->redirectToRoute('app_admin_faq_content');

}

#[Route('admin/faq/content/edit/{id}', name: 'app_admin_faq_content_edit')]

public function edit(Security $security, EntityManagerInterface $entityManager, Request $request, FaqContent $faqContent): Response
{
    $form = $this->createForm(FaqContentType::class, $faqContent);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $faqContent->setContentUpdate(new \DateTime('now'));
        $entityManager->persist($faqContent);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_faq_content');
    }

    $user = $this->getUserInfo($security);

    return $this->render('faq_content/add.html.twig', [
        'controller_name' => 'FaqContentController',
        'firstName' => $user['firstName'],
        'role' => $user['role'],
        'form' => $form->createView(),
    ]); 

}

//Route publique pour afficher les FAQ sur le site avec envoi en JSON

#[Route('/api/public/faq', name: 'app_faq_content', methods: ['GET'])]

public function faqContent(FaqContentRepository $faqContentRepository, FaqCategoryRepository $faqCategoryRepository, JsonResponseNormalizer $jsonResponseNormalizer): JsonResponse

{

    //Récupération de toutes les catégories de FAQ

    $categories = $faqCategoryRepository->findAll();

$response = [];

//Parcours de catégories pour récupérer les contenus associés
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


//$response[] = $categoryData;


}

$allFaqContentResponse = $jsonResponseNormalizer->respondSuccess(200, $response);
return $allFaqContentResponse;



/*
    $contents=$faqContentRepository->findAll();

    $contentsArray=[];

    foreach ($contents as $content) {
        $contentsArray[]=[
            'id'=>$content->getId(),
            'section'=>$content->getSection()->getCategory(),
            'title'=>$content->getTitle(),
            'content'=>$content->getContent(),
            'contentUpdate'=>$content->getContentUpdate(),
        ];
    }

    return new JsonResponse($contentsArray);

}
*/


    
    }
    }
