<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Form\StageType;
use App\Repository\StageRepository;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StageController extends AbstractController
{

    use UserInfoTrait;

    /**
     * Affiche la liste des salles de concert
     * Le contrôleur permet de gérer l'affichage de la liste des salles de concert
     * 
     * @param Security $security
     * @param StageRepository $stageRepository
     * @return Response
     */

    #[Route('/admin/concert/stage', name: 'app_admin_stage')]
    public function index(
        Security $security,
        StageRepository $stageRepository
    ): Response {

        $user = $this->getUserInfo($security);

        $stages = $stageRepository->findAll();

        return $this->render('stage/stage-index.html.twig', [
            'controller_name' => 'StageController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'stages' => $stages,


        ]);
    }

    /**
     * Route pour créer une nouvelle salle de concert
     * Le contrôleur permet de gérer l'ajout d'une salle de concert via un formulaire
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */

    #[Route('/admin/concert/stage/new', name: 'app_admin_stage_new')]

    public function add(
        Security $security,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {

        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stage);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_stage');
        }

        $user = $this->getUserInfo($security);

        return $this->render('stage/stage-add.html.twig', [
            'controller_name' => 'StageController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }

    /**
     * Route pour éditer une salle de concert
     * Le contrôleur permet de gérer l'édition d'une salle de concert via un formulaire
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Stage $stage
     * @param Request $request
     * @return Response 
     * 
     */

    #[Route('/admin/concert/stage/edit/{id}', name: 'app_admin_stage_edit')]

    public function edit(
        Security $security,
        EntityManagerInterface $entityManager,
        Stage $stage,
        Request $request
    ): Response {

        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stage);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_stage');
        }

        $user = $this->getUserInfo($security);

        return $this->render('stage/stage-edit.html.twig', [
            'controller_name' => 'StageController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }


    /**
     * Route pour supprimer une salle de concert
     * Le contrôleur permet de gérer la suppression d'une salle de concert via un formulaire
     * 
     * @param EntityManagerInterface $entityManager
     * @param Stage $stage
     * @return Response
     * 
     */

    #[Route('/admin/concert/stage/delete/{id}', name: 'app_admin_stage_delete')]

    public function delete(
        EntityManagerInterface $entityManager,
        Stage $stage
    ): Response {

        try {
            $entityManager->remove($stage);
            $entityManager->flush();
        } catch (Exception $exception) {

            $this->addFlash('Erreur', 'Impossible de supprimer cette scène, elle est utilisée pour un ou plusieurs concerts.');
        }


        return $this->redirectToRoute('app_admin_stage');
    }
}
