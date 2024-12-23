<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\PartnerCategoryRepository;
use App\Repository\PartnerRepository;
use App\Service\DeleteImagesService;
use App\Service\FileUploaderService;
use App\Service\JsonResponseNormalizer;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class PartnerController extends AbstractController
{
    use UserInfoTrait;

    /**
     * Affiche la liste des partenaires
     * Le contrôleur permet de gérer l'affichage de la liste des partenaires
     * 
     * @param Security $security
     * @param PartnerRepository $partnerRepository
     * @param PartnerCategoryRepository $partnerCategoryRepository
     * @param Request $request
     * @return Response
     * 
     */

    #[Route('/admin/partner', name: 'app_admin_partner')]
    public function index(Security $security, 
    PartnerRepository $partnerRepository,
    PartnerCategoryRepository $partnerCategoryRepository,
    Request $request
    ): Response
    {

        $user = $this->getUserInfo($security);

        $categoryFilter = $request->query->get('categoryId');

        $categories = $partnerCategoryRepository->findBy([], ['partnerCategoryName' => 'ASC']);

        if ($categoryFilter) {

            $partners = $partnerRepository->findBy(['category' => $categoryFilter], ['partnerName' => 'ASC']);
        } else {
            $partners = $partnerRepository->findBy([], ['partnerName' => 'ASC']);
        }
    

        return $this->render('partner/partner-index.html.twig', [
            'controller_name' => 'PartnerController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'partners' => $partners,
            'categories' => $categories,
            'categoryFilter' => $categoryFilter,
        ]);
    }


    /**
     * Route pour créer un nouveau partenaire
     * Le contrôleur permet de gérer l'ajout d'un partenaire via un formulaire
     *
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param FileUploaderService $fileUploaderService
     * @return Response
     */
    #[Route('/admin/partner/new', name: 'app_admin_partner_new')]

    public function add(Security $security, 
    EntityManagerInterface $entityManager, 
    Request $request, 
    FileUploaderService $fileUploaderService): Response
    {

        $partner = new Partner();

        $form = $this->createForm(PartnerType::class, $partner);

        $form->handleRequest($request);

        $user = $this->getUserInfo($security);

        if ($form->isSubmitted() && $form->isValid()) {

            //Gestion de l'upload de l'image

            $file = $form->get('file')->getData();

            if ($file) {

                $targetDirectory = $this->getParameter('upload_logos_directory');

                $fileName = $fileUploaderService->upload($file, $targetDirectory);

                $partner->setPartnerLogo($fileName);
            }



            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_partner');
        }

        return $this->render('partner/partner-add.html.twig', [
            'controller_name' => 'PartnerController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }

    /**
     * Route pour éditer un partenaire
     * Le contrôleur permet de gérer l'édition d'un partenaire via un formulaire
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param Partner $partner
     * @param FileUploaderService $fileUploaderService
     * @param DeleteImagesService $deleteImagesService
     * @return Response
     * 
     */
    #[Route('/admin/partner/edit/{id}', name: 'app_admin_partner_edit')]

    public function edit(Security $security, 
    EntityManagerInterface $entityManager, 
    Request $request, 
    Partner $partner, 
    FileUploaderService $fileUploaderService, 
    DeleteImagesService $deleteImagesService): Response
    {

        $form = $this->createForm(PartnerType::class, $partner);

        $form->handleRequest($request);

        $user = $this->getUserInfo($security);

        if ($form->isSubmitted() && $form->isValid()) {



            $file = $form->get('file')->getData();

            if ($file) {

                $targetDirectory = $this->getParameter('upload_logos_directory');

                $oldImage = $partner->getPartnerLogo();


                $deleteImagesService->deleteImages($oldImage, $targetDirectory);


                $fileName = $fileUploaderService->upload($file, $targetDirectory);

                $partner->setPartnerLogo($fileName);
            } else {
                $partner->setPartnerLogo(null);
            }

            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_partner');
        }



        $currentLogoName = $partner->getPartnerLogo();

        if ($currentLogoName != null) {
            $currentLogoPath = './images/logos/' . $currentLogoName;
        } else {
            $currentLogoPath = null;
        }



        return $this->render('partner/partner-edit.html.twig', [
            'controller_name' => 'PartnerController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
            'urlLogo' => $currentLogoPath,
        ]);
    }

    /**
     * Route pour supprimer un partenaire
     * Le contrôleur permet de gérer la suppression d'un partenaire
     * 
     * @param EntityManagerInterface $entityManager
     * @param Partner $partner
     * @param DeleteImagesService $deleteImagesService
     * @return Response
     */

    #[Route('/admin/partner/delete/{id}', name: 'app_admin_partner_delete')]

    public function delete(EntityManagerInterface $entityManager, 
    Partner $partner, 
    DeleteImagesService $deleteImagesService): Response
    {

        try {

            $logoName = $partner->getPartnerLogo();
            $directory = $this->getParameter('upload_logos_directory');
            $deleteImagesService->deleteImages($logoName, $directory);
            $entityManager->remove($partner);
            $entityManager->flush();
        } catch (\Exception $e) {

            $this->addFlash('danger', 'Erreur lors de la suppression du partenaire. Veuillez contacter l\'administrateur.');
        }

        return $this->redirectToRoute('app_admin_partner');
    }


    /**
     * Route publique pour l'API pour afficher la liste des partenaires
     * réponses en JSON
     * 
     * @param PartnerRepository $partnerRepository
     * @param JsonResponseNormalizer $jsonResponseNormalizer
     * @return JsonResponse
     * 
     */

    #[Route('/api/public/partner', name: 'app_public_partner', methods: ['GET'])]

    public function public(PartnerRepository $partnerRepository, 
    JsonResponseNormalizer $jsonResponseNormalizer): JsonResponse
    {



        $partners = $partnerRepository->findAll();

        $partnersArray = [];



        foreach ($partners as $partner) {

            //verifie si l'url du logo est null ou non
            if ($partner->getPartnerLogo() != null) {
                $urlLogo = "https://backend.nationsound2024-festival.fr/images/logos/" . $partner->getPartnerLogo();
            } else {
                $urlLogo = null;
            }


            $partnersArray[] = [
                'id' => $partner->getPartnerId(),
                'name' => $partner->getPartnerName(),
                'url_logo' => $urlLogo,
                'description' => $partner->getPartnerDescription(),
                'category' => $partner->getPartnerCategory()->getPartnerCategoryName(),
            ];
        }


        $response = $jsonResponseNormalizer->respondSuccess(Response::HTTP_OK, $partnersArray);
    
        $response->setSharedMaxAge(21600);
        $response->setPublic();

        return $response;
    }



    /**
     * Route publique pour l'API pour afficher un partenaire spécifique
     * réponses en JSON
     * 
     * @param Partner $partner
     * @param JsonResponseNormalizer $jsonResponseNormalizer
     * @return JsonResponse
     * 
     */
    //Route publique pour l'API pour afficher la liste des partenaires avec un  id de category spécifique 

    #[Route('/api/public/partner/category/{id}', name: 'app_public_partnerbycategory', methods: ['GET'])]

    public function publicByCategory(PartnerRepository $partnerRepository, 
    int $id, 
    JsonResponseNormalizer $jsonResponseNormalizer): JsonResponse
    {


        $partners = $partnerRepository->findBy(['category' => $id]);

        $partnersArray = [];


   

        foreach ($partners as $partner) {
            //verifie si l'url du logo est null ou non
            if ($partner->getPartnerLogo() != null) {
                $urlLogo = "https://backend.nationsound2024-festival.fr/images/logos/" . $partner->getPartnerLogo();
            } else {
                $urlLogo = null;
            }

            $partnersArray[] = [

                'id' => $partner->getPartnerId(),
                'name' => $partner->getPartnerName(),
                'url_logo' => $urlLogo,
                'description' => $partner->getPartnerDescription(),
                'category' => $partner->getPartnerCategory()->getPartnerCategoryName(),
            ];
        }

        $response = $jsonResponseNormalizer->respondSuccess(Response::HTTP_OK, $partnersArray);

        $response->setSharedMaxAge(21600);
        $response->setPublic();

        return $response;
    
    }


}
