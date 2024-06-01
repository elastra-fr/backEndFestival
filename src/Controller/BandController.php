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
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class BandController extends AbstractController
{
    use UserInfoTrait;
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
    public function add(Security $security, EntityManagerInterface $entityManagerInterface, Request $request, SluggerInterface $sluggerInterface): Response
    {

        $band = new Band();
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);
        $user = $this->getUserInfo($security);

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
                }

                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $fileName = $safeFilename . '-' . uniqid() . '.' . $extension;

                try {
                    $file->move(
                        $this->getParameter('upload_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                }

                $fileUrl =  '/images/bands/' . $fileName;
                $band->setUrlImage($fileUrl);
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

        if ($imageUrl) {

            unlink('.' . $imageUrl);
        }


        $entityManagerInterface->remove($band);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('app_admin_band');
    }


    #[Route('/admin/band/edit/{id}', name: 'app_admin_band_edit')]

    public function edit(Security $security, EntityManagerInterface $entityManagerInterface, Request $request, Band $band, SluggerInterface $sluggerInterface): Response
    {

        $form = $this->createForm(BandType::class, $band);

        $user = $this->getUserInfo($security);
        $form->handleRequest($request);


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

                }

                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $sluggerInterface->slug($originalFilename);
                $fileName = $safeFilename . '-' . uniqid() . '.' . $extension;

                try {
                    $file->move(
                        $this->getParameter('upload_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                }

                $fileUrl =  '/images/bands/' . $fileName;
                $band->setUrlImage($fileUrl);
            }

            $entityManagerInterface->persist($band);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_admin_band');
        }

        return $this->render('band/edit.html.twig', [
            'controller_name' => 'BandController',
            'form' => $form->createView(),
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'urlImage' => $band->getUrlImage(),

        ]);
    }
}
