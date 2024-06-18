<?php

namespace App\Controller;

use App\Entity\MusicStyle;
use App\Form\MusicStyleType;
use App\Repository\MusicStyleRepository;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MusicStyleController extends AbstractController
{
    use UserInfoTrait;

    /**
     * Route pour afficher la liste des styles de musique
     * Le controller permet d'afficher la liste des styles de musique 
     * @param Security $security
     * @param MusicStyleRepository $musicStyleRepository
     * @return Response
     * 
     */

    #[Route('/admin/band/style', name: 'app_admin_style')]
    public function index(
        Security $security,
        MusicStyleRepository $musicStyleRepository
    ): Response {

        $user = $this->getUserInfo($security);

        $styles = $musicStyleRepository->findBy([], ['name' => 'ASC']);

        return $this->render('music_style/music-style-index.html.twig', [
            'controller_name' => 'MusicStyleController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'styles' => $styles,
        ]);
    }

    /**
     * Route pour ajouter un style de musique via un formulaire
     * Le controller permet d'ajouter un style de musique via un formulaire
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */


    #[Route('/admin/band/style/new', name: 'app_admin_style_new')]
    public function add(
        Security $security,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {


        $musicStyle = new MusicStyle();
        $form = $this->createForm(MusicStyleType::class, $musicStyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($musicStyle);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_style');
        }

        $user = $this->getUserInfo($security);

        return $this->render('music_style/music-style-add.html.twig', [
            'controller_name' => 'MusicStyleController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }

    /**
     * Route pour supprimer un style de musique
     * Le controller permet de supprimer un style de musique
     * En cas de violation de clé étrangère, un message flash est affiché
     * @param EntityManagerInterface $entityManager
     * @param MusicStyle $musicStyle
     * @return Response
     */
    #[Route('/admin/band/style/delete/{id}', name: 'app_admin_style_delete')]

    public function delete(
        EntityManagerInterface $entityManager,
        MusicStyle $musicStyle
    ): Response {

        try {
            $entityManager->remove($musicStyle);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_style');
        } catch (\Exception $e) {

            $this->addFlash('danger', 'Impossible de supprimer ce style de musique car il est utilisé par un ou plusieurs groupes');
            return $this->redirectToRoute('app_admin_style');
        }
    }

    /**
     * Route pour modifier un style de musique
     * Le controller permet de modifier un style de musique
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     */

    #[Route('/admin/band/style/edit/{id}', name: 'app_admin_style_edit')]

    public function edit(
        Security $security,
        EntityManagerInterface $entityManager,
        Request $request,
        MusicStyle $musicStyle
    ): Response {

        $form = $this->createForm(MusicStyleType::class, $musicStyle);

        $user = $this->getUserInfo($security);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($musicStyle);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_style');
        }

        return $this->render('music_style/music-style-edit.html.twig', [
            'controller_name' => 'MusicStyleController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }
}
