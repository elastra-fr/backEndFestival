<?php

namespace App\Controller;

use App\Repository\ConcertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Trait\UserInfoTrait;
use Symfony\Bundle\SecurityBundle\Security;
use App\Service\JsonResponseNormalizer;
use App\Entity\Concert;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ConcertType;
use App\Service\SlotCheckerService;

class ConcertController extends AbstractController
{
    use UserInfoTrait;
    #[Route('/admin/concert', name: 'app_admin_concert')]
    public function index(Security $security, ConcertRepository $concertRepository): Response
    {


        $user = $this->getUserInfo($security);

        $concerts = $concertRepository->findAll();

        $concertsList = [];

        foreach ($concerts as $concert) {
            $concertsList[] = [
                'id' => $concert->getId(),
                'date' => $concert->getConcertDate()->format('Y-m-d H:i:s'),
                'location' => $concert->getStage()->getName(),
                'description' => $concert->getArtist()->getDescription(),
                'artist' => $concert->getArtist()->getName(),
            ];
        }



        
        return $this->render('concert/concert-index.html.twig', [
            'controller_name' => 'ConcertController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'concerts' => $concertsList,

        ]);


    }

    #[Route('/admin/concert/new', name: 'app_admin_concert_new')]

    public function add(Security $security, EntityManagerInterface $entityManager, Request $request, SlotCheckerService $slotCheckerService): Response
    {

        $concert = new Concert();

        $form = $this->createForm(ConcertType::class, $concert);

        $form->handleRequest($request);

        $user = $this->getUserInfo($security);

        if ($form->isSubmitted() && $form->isValid()) {

            $concertDateTime = $concert->getConcertDate();
            $stageId = $concert->getStage()->getId();

            if ($slotCheckerService->isSlotTaken($concertDateTime, $stageId)) {
                $this->addFlash('danger', 'Ce créneau est déjà pris. Consultez la programmation pour choisir un autre créneau.');
         
            }

            else {
                $entityManager->persist($concert);
                $entityManager->flush();
                return $this->redirectToRoute('app_admin_concert');
            }



        }

        return $this->render('concert/concert-new.html.twig', [
            'controller_name' => 'ConcertController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);

    }

    #[Route('/admin/concert/edit/{id}', name: 'app_admin_concert_edit')]

    public function edit(Security $security, EntityManagerInterface $entityManager, Request $request, Concert $concert, SlotCheckerService $slotCheckerService): Response
    {

        $form = $this->createForm(ConcertType::class, $concert);

        $user = $this->getUserInfo($security);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $concertDateTime = $concert->getConcertDate();
            $stageId = $concert->getStage()->getId();

            if ($slotCheckerService->isSlotTaken($concertDateTime, $stageId)) {
                $this->addFlash('danger', 'Ce créneau est déjà pris. Consultez la programmation pour choisir un autre créneau.');
            }

            else {

                            $entityManager->persist($concert);
                             $entityManager->flush();

                             return $this->redirectToRoute('app_admin_concert');
        }

            }



        return $this->render('concert/concert-new.html.twig', [
            'controller_name' => 'ConcertController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);

    }


    #[Route('/admin/concert/delete/{id}', name: 'app_admin_concert_delete')]

    public function delete(Security $security, EntityManagerInterface $entityManager, Concert $concert): Response
    {

        $entityManager->remove($concert);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_concert');

    }





#Route publique pour afficher les concerts
    #[Route('/api/public/concert', name: 'app_api_concert')]
    public function concert(ConcertRepository $concertRepository, JsonResponseNormalizer $jsonResponseNormalizer): Response
    {
        
        $concerts = $concertRepository->findAll();

        $concertsList = [];

        

        foreach ($concerts as $concert) {
            $imageName = $concert->getArtist()->getUrlImage();
            $commonPath = 'https://backend.nationsound2024-festival.fr/images/bands/';
            $localPath = './images/bands/';

/*
            $imagesPath = [
                'original' => $commonPath . $imageName, 
                '600' => $commonPath . '600-' . $imageName,
                '400' => $commonPath . '400-' . $imageName,
                '200' => $commonPath . '200-' . $imageName,
            ];

*/



            $imagesPath = [
        'original' => file_exists($localPath.$imageName) ? $commonPath.$imageName : null,
        '600' => file_exists($localPath. '600-'.$imageName) ? $commonPath.'600-' .$imageName : null,
        '400' => file_exists($localPath. '400-'. $imageName) ? $commonPath.'400-'.$imageName : null,
        '200' => file_exists($localPath. '200-'. $imageName) ? $commonPath.'200-'.$imageName : null,
    ];

    var_dump($localPath. $imageName);
            

            //$imagePath = 'https://backend.nationsound2024-festival.fr/images/bands/' . $imageName;
            $concertsList[] = [
                'id' => $concert->getId(),
                'date' => $concert->getConcertDate()->format('Y-m-d H:i:s'),
                'location' => $concert->getStage()->getName(),
                'description' => $concert->getArtist()->getDescription(),
                'artist' => $concert->getArtist()->getName(),
                'images' => $imagesPath,
            ];
        }

        $concerts = $jsonResponseNormalizer->respondSuccess(200, $concertsList);
        return $concerts;

    }






}


