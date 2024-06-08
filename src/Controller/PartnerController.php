<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\PartnerRepository;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\JsonResponseNormalizer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;




class PartnerController extends AbstractController
{
    use UserInfoTrait;

    #[Route('/admin/partner', name: 'app_admin_partner')]
    public function index(Security $security, PartnerRepository $partnerRepository): Response
    {

        $user=$this->getUserInfo($security);

        $partners = $partnerRepository->findAll();

        return $this->render('partner/index.html.twig', [
            'controller_name' => 'PartnerController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'partners' => $partners,
        ]);

    }

    #[Route('/admin/partner/new', name: 'app_admin_partner_new')]

    public function add(Security $security, EntityManagerInterface $entityManager, Request $request, SluggerInterface $sluggerInterface): Response
    {

        $partner=new Partner();

        $form=$this->createForm(PartnerType::class, $partner);

        $form->handleRequest($request);

        $user=$this->getUserInfo($security);

                if ($form->isSubmitted() && $form->isValid()) {

            //Gestion de l'upload de l'image

            $file = $form->get('file')->getData();

            if ($file) {


                switch ($file->getClientMimeType()) {
                    case 'image/jpeg':
                        $extension = 'jpg'; // Utiliser l'extension .jpg pour les fichiers JPEG
                        break;
                    case 'image/png':
                        $extension = 'png'; // Utiliser l'extension .png pour les fichiers PNG
                        break;
                    case 'image/avif':
                        $extension = 'avif'; // Utiliser l'extension .avif pour les fichiers AVIF
                        break;
                    case 'image/webp':
                        $extension = 'webp'; // Utiliser l'extension .webp pour les fichiers WebP
                        break;
                        // Ajouter d'autres cas pour d'autres formats de fichiers si nécessaire

                    case 'image/svg+xml':
                        $extension = 'svg'; // Utiliser l'extension .svg pour les fichiers SVG
                        break;
                }

                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $fileName = $safeFilename . '-' . uniqid() . '.' . $extension;

                try {
                    $file->move(
                        $this->getParameter('upload_logos_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                }

                $fileUrl =  '/images/logos/' . $fileName;
                $partner->setUrlLogo($fileUrl);
            }



            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_partner');


    }

        return $this->render('partner/add.html.twig', [
            'controller_name' => 'PartnerController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);

    }


    #[Route('/admin/partner/edit/{id}', name: 'app_admin_partner_edit')]

    public function edit(Security $security, EntityManagerInterface $entityManager, Request $request, Partner $partner, SluggerInterface $sluggerInterface): Response
    {

        $form=$this->createForm(PartnerType::class, $partner);

        $form->handleRequest($request);

        $user=$this->getUserInfo($security);

        if ($form->isSubmitted() && $form->isValid()) {

            //Gestion de l'upload de l'image

            $file = $form->get('file')->getData();

            if ($file) {


                switch ($file->getClientMimeType()) {
                    case 'image/jpeg':
                        $extension = 'jpg'; // Utiliser l'extension .jpg pour les fichiers JPEG
                        break;
                    case 'image/png':
                        $extension = 'png'; // Utiliser l'extension .png pour les fichiers PNG
                        break;
                    case 'image/avif':
                        $extension = 'avif'; // Utiliser l'extension .avif pour les fichiers AVIF
                        break;
                    case 'image/webp':
                        $extension = 'webp'; // Utiliser l'extension .webp pour les fichiers WebP
                        break;
                        // Ajouter d'autres cas pour d'autres formats de fichiers si nécessaire

                    case 'image/svg+xml':
                        $extension = 'svg'; // Utiliser l'extension .svg pour les fichiers SVG
                        break;

                }

                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $fileName = $safeFilename . '-' . uniqid() . '.' . $extension;

                try {
                    $file->move(
                        $this->getParameter('upload_logos_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                }

                $fileUrl =  '/images/logos/' . $fileName;
                $partner->setUrlLogo($fileUrl);
            }

            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_partner');

        }

        return $this->render('partner/edit.html.twig', [
            'controller_name' => 'PartnerController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
            'urlLogo' => $partner->getUrlLogo(),
        ]);


    }

    #[Route('/admin/partner/delete/{id}', name: 'app_admin_partner_delete')]

    public function delete(Security $security, EntityManagerInterface $entityManager, Partner $partner): Response
    {

        $logoUrl=$partner->getUrlLogo();

        if ($logoUrl != null) {
            
            unlink('.'.$logoUrl);
        }

        $entityManager->remove($partner);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_partner');


    }

    //Route publique pour l'API pour afficher les partenaires avec retour en JSON

    #[Route('/api/public/partner', name: 'app_public_partner', methods: ['GET'])]   

    public function public(PartnerRepository $partnerRepository, Request $request, JsonResponseNormalizer $jsonResponseNormalizer, UrlGeneratorInterface $urlGeneratorInterface): JsonResponse
    {



        $partners=$partnerRepository->findAll();

        //$publicUrlImage = $urlGeneratorInterface->generate('/public/images/logos', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $partnersArray=[];

        foreach ($partners as $partner) {
            $partnersArray[]=[
                'id'=>$partner->getId(),
                'name'=>$partner->getName(),
                'url_logo'=>"https://https://backend.nationsound2024-festival.fr".$partner->getUrlLogo(),
                'description'=>$partner->getDescription(),
                'category'=>$partner->getCategory()->getCategory(),
            ];
        }

        return $jsonResponseNormalizer->respondSuccess(Response::HTTP_OK, $partnersArray);

    }

    //Route publique pour l'API pour afficher la liste des partenaires avec un  id de category spécifique 

    #[Route('/api/public/partner/category/{id}', name: 'app_public_partnerbycategory', methods: ['GET'])]

    public function publicByCategory(PartnerRepository $partnerRepository, Request $request, int $id, JsonResponseNormalizer $jsonResponseNormalizer, UrlGeneratorInterface $urlGeneratorInterface): JsonResponse
    {


        $partners=$partnerRepository->findBy(['category'=>$id]);

        $partnersArray=[];

        
//$publicUrlImage = $urlGeneratorInterface->generate('/public/images/logos', [], UrlGeneratorInterface::ABSOLUTE_URL);

        foreach ($partners as $partner) {
            $partnersArray[]=[
                'id'=>$partner->getId(),
                'name'=>$partner->getName(),
                'url_logo'=>"https://https://backend.nationsound2024-festival.fr".$partner->getUrlLogo(),
                'description'=>$partner->getDescription(),
                'category'=>$partner->getCategory()->getCategory(),
            ];
        }

        return $jsonResponseNormalizer->respondSuccess(Response::HTTP_OK, $partnersArray);


    }




}
