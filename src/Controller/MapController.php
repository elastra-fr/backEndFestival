<?php

namespace App\Controller;

use App\Entity\MapPoint;
use App\Form\MapPointEntityType;
use App\Repository\MapPointRepository;
use App\Repository\MapPointsCategoryRepository;
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
    public function index(Security $security, 
    MapPointRepository $mapPointRepository, 
    Request $request, 
    EntityManagerInterface $entityManagerInterface, 
    MapPointsCategoryRepository $mapPointsCategoryRepository): Response
    {
        $categoryFilter = $request->query->get('categoryId');

        $user = $this->getUserInfo($security);

        $mapPoints = $mapPointRepository->findAll();

        $categories = $mapPointsCategoryRepository->findAll();

        if ($categoryFilter) {
            $mapPoints = $mapPointRepository->findBy(['type' => $categoryFilter]);
        } else {
            $mapPoints = $mapPointRepository->findAll();
        }

        $mapPointsList=[];

        foreach ($mapPoints as $mapPoint) {
            $mapPointsList[] = [
                'title' => $mapPoint->getTitle(),
                'description' => $mapPoint->getDescription(),
                'latitude' => $mapPoint->getLatitude(),
                'longitude' => $mapPoint->getLongitude(),
                'type' => $mapPoint->getType()->getPointCategory(),
                'img'=>$mapPoint->getType()->getPointUrl(),
            ];
        }


        //Gestion du formulaire

        $mapPoint=new MapPoint();
        $form = $this->createForm(MapPointEntityType::class, $mapPoint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mapPoint = $form->getData();
            $entityManagerInterface->persist($mapPoint);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_admin_map');
        }


        $mapPointsJson = json_encode($mapPointsList);

        return $this->render('map/index.html.twig', [
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

    public function add(Security $security, 
    EntityManagerInterface $entityManagerInterface, 
    Request $request): Response
    {

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

    public function delete(EntityManagerInterface $entityManagerInterface, 
    MapPoint $mapPoint): Response
    {
        $entityManagerInterface->remove($mapPoint);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('app_admin_map');

    }

    /**
     * Modifie un point de la carte en fonction de son identifiant
     */

    //#[Route('/admin/map/points/edit/{id}', name: 'app_admin_map_points_edit')]
/*
    public function edit(Security $security, EntityManagerInterface $entityManagerInterface, Request $request, MapPoint $mapPoint): Response
    {
        $form = $this->createForm(MapPointEntityType::class, $mapPoint);
        $form->handleRequest($request);
        $user = $this->getUserInfo($security);

        if ($form->isSubmitted() && $form->isValid()) {
            $mapPoint = $form->getData();
            $entityManagerInterface->persist($mapPoint);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_admin_map');
        }

        return $this->render('map/map-point-edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
*/

//Route publique pour retourner les points de la carte au format JSON

    #[Route('api/public/map/points', name: 'app_map_points')]

    public function getMapPoints(MapPointRepository $mapPointRepository): Response
    {
        $mapPoints = $mapPointRepository->findAll();

        $mapPointsList=[];

        foreach ($mapPoints as $mapPoint) {
            $mapPointsList[] = [
                'title' => $mapPoint->getTitle(),
                'description' => $mapPoint->getDescription(),
                'latitude' => $mapPoint->getLatitude(),
                'longitude' => $mapPoint->getLongitude(),
                'type' => $mapPoint->getType()->getPointCategory(),
                'img'=>$mapPoint->getType()->getPointUrl(),
            ];
        }

        $mapPointsJson = json_encode($mapPointsList);

        return new Response($mapPointsJson, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

}

