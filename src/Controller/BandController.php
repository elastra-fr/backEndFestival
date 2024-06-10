<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Trait\UserInfoTrait;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Band;
use App\Repository\BandRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\BandType;
use App\Service\FileUploaderService;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class BandController extends AbstractController
{
    use UserInfoTrait;


    /**
     * Affiche la liste des groupes/artistes
     *
     * @param Security $security
     * @param BandRepository $bandRepository
     * @return Response
     */
    #[Route('/admin/band', name: 'app_admin_band')]
    public function index(Security $security, BandRepository $bandRepository): Response
    {
        $user = $this->getUserInfo($security);

        $bands = $bandRepository->findAll();

        return $this->render('band/index.html.twig', [
            'controller_name' => 'BandController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'bands' => $bands,
        ]);
    }


    #[Route('/admin/band/new', name: 'app_admin_band_new')]
    public function add(Security $security, EntityManagerInterface $entityManagerInterface, Request $request, SluggerInterface $sluggerInterface, FileUploaderService $fileUploaderService): Response
    {

        $band = new Band();
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);
        $user = $this->getUserInfo($security);

        if ($form->isSubmitted() && $form->isValid()) {

            //Gestion de l'upload de l'image

            $file = $form->get('file')->getData();

            if ($file) {

                $targetDirectory=$this->getParameter('upload_bands_directory');

                $fileName = $fileUploaderService->upload($file, $targetDirectory);
                $band->setUrlImage($fileName);

            }
  


            $entityManagerInterface->persist($band);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_admin_band');
        }

        return $this->render('band/add.html.twig', [
            'controller_name' => 'BandController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }


    #[Route('/admin/band/delete/{id}', name: 'app_admin_band_delete')]

    public function delete(Security $security, EntityManagerInterface $entityManagerInterface, Band $band): Response
    {

        // Suppression de l'image associée au groupe
        $imageUrl = $band->getUrlImage();
$imageName=$band->getUrlImage();
        $imagePath = './images/bands/' . $imageName;

        if ($imageUrl) {


          
                unlink($imagePath);
            
        }

        
        $entityManagerInterface->remove($band);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('app_admin_band');

 
    }


    #[Route('/admin/band/edit/{id}', name: 'app_admin_band_edit')]

    public function edit(Security $security, EntityManagerInterface $entityManagerInterface, Request $request, Band $band, fileUploaderService $fileUploaderService): Response
    {

        $form = $this->createForm(BandType::class, $band);

        $user = $this->getUserInfo($security);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            //Gestion de l'upload de l'image

            $file = $form->get('file')->getData();

            if ($file) {
    
                    $targetDirectory=$this->getParameter('upload_bands_directory');
    
                    $fileName = $fileUploaderService->upload($file, $targetDirectory);
                    $band->setUrlImage($fileName);
            }

            $entityManagerInterface->persist($band);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_admin_band');
        }

        $currentImageName=$band->getUrlImage();
        $currentImagePath = './images/bands/' . $currentImageName;

        return $this->render('band/edit.html.twig', [
            'controller_name' => 'BandController',
            'form' => $form->createView(),
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'urlImage' => $currentImagePath,

        ]);
    }
}
