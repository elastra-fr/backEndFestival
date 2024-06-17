<?php

namespace App\Controller;

use App\Entity\MapPointsCategory;
use App\Form\MapPointsCategoryType;
use App\Repository\MapPointsCategoryRepository;
use App\Service\JsonResponseNormalizer;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class MapPointsCategoryController extends AbstractController
{
    use UserInfoTrait;

    /**
     * Route pour la page d'administration des catégories de points sur la carte
     * 
     * @param Security $security
     * @param MapPointsCategoryRepository $mapPointsCategoryRepository
     * @return Response
     * 
     */

    #[Route('/admin/map/points/category', name: 'app_admin_map_points_category')]
    public function index(
        Security $security,
        MapPointsCategoryRepository $mapPointsCategoryRepository
    ): Response {

        $user = $this->getUserInfo($security);

        $categories = $mapPointsCategoryRepository->findAll();

        return $this->render('map_points_category/index.html.twig', [
            'controller_name' => 'MapPointsCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'categories' => $categories,
        ]);
    }

    /**
     * Route pour l'ajout d'une catégorie de points sur la carte
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param SluggerInterface $sluggerInterface
     * @return Response
     */

    #[Route('/admin/map/points/category/new', name: 'app_admin_map_points_category_new')]
    public function add(
        Security $security,
        EntityManagerInterface $entityManager,
        Request $request,
        SluggerInterface $sluggerInterface
    ): Response {

        $mapPointsCategory = new MapPointsCategory();

        $form = $this->createForm(MapPointsCategoryType::class, $mapPointsCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('file')->getData();

            if ($file) {

                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $sluggerInterface->slug($originalFilename);

                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('upload_icons_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $mapPointsCategory->setPointUrl($newFilename);
            }

            $entityManager->persist($mapPointsCategory);

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_map_points_category');
        }

        $user = $this->getUserInfo($security);

        return $this->render('map_points_category/add.html.twig', [
            'controller_name' => 'MapPointsCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }

    /**
     * Route pour l'édition d'une catégorie de points sur la carte
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param MapPointsCategory $mapPointsCategory
     * @param SluggerInterface $sluggerInterface
     * @return Response
     * 
     */

    #[Route('/admin/map/points/category/edit/{id}', name: 'app_admin_map_points_category_edit')]

    public function edit(
        Security $security,
        EntityManagerInterface $entityManager,
        Request $request,
        MapPointsCategory $mapPointsCategory,
        SluggerInterface $sluggerInterface
    ): Response {

        $form = $this->createForm(MapPointsCategoryType::class, $mapPointsCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('file')->getData();

            if ($file) {

                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $sluggerInterface->slug($originalFilename);

                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('upload_icons_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $mapPointsCategory->setPointUrl($newFilename);
            }


            $entityManager->persist($mapPointsCategory);

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_map_points_category');
        }

        $user = $this->getUserInfo($security);

        return $this->render('map_points_category/add.html.twig', [
            'controller_name' => 'MapPointsCategoryController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }

    /**
     * Route pour la suppression d'une catégorie de points sur la carte
     * 
     * @param EntityManagerInterface $entityManager
     * @param MapPointsCategory $mapPointsCategory
     * @return Response
     * 
     */

    #[Route('/admin/map/points/category/delete/{id}', name: 'app_admin_map_points_category_delete')]

    public function delete(
        EntityManagerInterface $entityManager,
        MapPointsCategory $mapPointsCategory
    ): Response {
        $entityManager->remove($mapPointsCategory);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_map_points_category');
    }


/**
 * Route publique pour retourner les catégories de points sur la carte triées par ordre alphabétique au format JSON
 * 
 * @param MapPointsCategoryRepository $mapPointsCategoryRepository
 * @param JsonResponseNormalizer $jsonResponseNormalizer
 * @return Response
 * 
 */

    #[Route('api/public/map/points/category', name: 'app_api_map_points_category')]
    public function publicIndex(MapPointsCategoryRepository $mapPointsCategoryRepository, 
    JsonResponseNormalizer $jsonResponseNormalizer): Response
    {
        $categories = $mapPointsCategoryRepository->findBy([], ['PointCategory' => 'ASC']);

        $categoriesData = [];

        foreach ($categories as $category) {
            $categoriesData[] = [
                'id' => $category->getId(),
                'PointCategory' => $category->getPointCategory(),
            ];
        }

        $response = $jsonResponseNormalizer->respondSuccess(200, $categoriesData);

        return $response;
    }

}
