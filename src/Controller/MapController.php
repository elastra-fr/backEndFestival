<?php

namespace App\Controller;

use App\Entity\MapPoint;
use App\Form\MapPointEntityType;
use App\Repository\MapPointRepository;
use App\Repository\MapPointsCategoryRepository;
use App\Service\JsonResponseNormalizer;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MapController extends AbstractController
{

    use UserInfoTrait;
    #[Route('/admin/map', name: 'app_admin_map')]
    public function index(
        Security $security,
        MapPointRepository $mapPointRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        MapPointsCategoryRepository $mapPointsCategoryRepository
    ): Response {
        $categoryFilter = $request->query->get('categoryId');

        $user = $this->getUserInfo($security);

        $mapPoints = $mapPointRepository->findAll();

        $categories = $mapPointsCategoryRepository->findBy([], ['mapPointCategoryName' => 'ASC']);

        if ($categoryFilter) {
            $mapPoints = $mapPointRepository->findBy(['mapPointCategory' => $categoryFilter], );
        } else {
            $mapPoints = $mapPointRepository->findAll();
        }

        $mapPointsList = [];

        foreach ($mapPoints as $mapPoint) {
            $mapPointsList[] = [
                'title' => $mapPoint->getMapPointTitle(),
                'description' => $mapPoint->getMapPointDescription(),
                'latitude' => $mapPoint->getLatitude(),
                'longitude' => $mapPoint->getLongitude(),
                'type' => $mapPoint->getMapPointCategory()->getMapPointCategoryName(),
                'img' => $mapPoint->getMapPointCategory()->getMapPointIconUrl(),
            ];
        }


        //Gestion du formulaire

        $mapPoint = new MapPoint();
        $form = $this->createForm(MapPointEntityType::class, $mapPoint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mapPoint = $form->getData();
            $entityManagerInterface->persist($mapPoint);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_admin_map');
        }


        $mapPointsJson = json_encode($mapPointsList);

        return $this->render('map/map-index.html.twig', [
            'controller_name' => 'MapController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'mapPoints' => $mapPoints,
            'form' => $form->createView(),
            'categories' => $categories,
            'categoryFilter' => $categoryFilter,
            'mapPointsJson' => $mapPointsJson,
        ]);
    }

    /**
     * Ajoute un point sur la carte avec les informations saisies dans le formulaire
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManagerInterface
     * @param Request $request
     * @return Response
     * 
     */

    #[Route('/admin/map/points/new', name: 'app_admin_map_points_new')]

    public function add(
        Security $security,
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ): Response {

        $mapPoint = new MapPoint();
        $form = $this->createForm(MapPointEntityType::class, $mapPoint);
        var_dump($form);
        $form->handleRequest($request);
        $user = $this->getUserInfo($security);

        if ($form->isSubmitted() && $form->isValid()) {
            $mapPoint = $form->getData();
            $entityManagerInterface->persist($mapPoint);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_admin_map');
        }

        return $this->render('map/map-point-new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Supprime un point de la carte en fonction de son identifiant
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManagerInterface
     * @param MapPoint $mapPoint
     * @return Response
     */

    #[Route('/admin/map/points/delete/{id}', name: 'app_admin_map_points_delete')]

    public function delete(
        EntityManagerInterface $entityManagerInterface,
        MapPoint $mapPoint
    ): Response {
        $entityManagerInterface->remove($mapPoint);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('app_admin_map');
    }




    /**
     * Route publique pour retourner les points de la carte au format JSON tous ou filtrés par catégorie
     * 
     * @param MapPointRepository $mapPointRepository
     * @param int|null $id
     * @param JsonResponseNormalizer $jsonResponseNormalizer
     * @return Response
     * 
     */

    #[Route('api/public/map/marker/{id}', name: 'app_map_points', methods: ['GET'], defaults: ['id' => null])]

    public function getMapPoints(
        MapPointRepository
        $mapPointRepository,
        ?int $id,
        JsonResponseNormalizer $jsonResponseNormalizer
    ): Response {


        if ($id !== null) {


            $mapPoints = $mapPointRepository->findBy(['mapPointCategory' => $id]);
        } else {




            $mapPoints = $mapPointRepository->findAll();
        }


        $mapPointsList = [];

        foreach ($mapPoints as $mapPoint) {

            $ImgFileName = $mapPoint->getMapPointCategory()->getMapPointIconUrl();
            $commonPath = 'https://backend.nationsound2024-festival.fr/images/icons/';

            $mapPointsList[] = [
                'title' => $mapPoint->getMapPointTitle(),
                'description' => $mapPoint->getMapPointDescription(),
                'latitude' => $mapPoint->getLatitude(),
                'longitude' => $mapPoint->getLongitude(),
                'type' => $mapPoint->getMapPointCategory()->getMapPointCategory(),
                'img' => $commonPath . $ImgFileName,
            ];
        }

         
        $response = $jsonResponseNormalizer->respondSuccess(Response::HTTP_OK, $mapPointsList);

        $response->setSharedMaxAge(1800);
        $response->setPublic();

        return $response;
        
    }
}
