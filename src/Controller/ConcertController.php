<?php

namespace App\Controller;

use App\Entity\Concert;
use App\Form\ConcertType;
use App\Repository\ConcertRepository;
use App\Repository\MusicStyleRepository;
use App\Repository\StageRepository;
use App\Service\JsonResponseNormalizer;
use App\Service\SlotCheckerService;
use App\Trait\UserInfoTrait;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class ConcertController extends AbstractController
{
    use UserInfoTrait;


    /**
     * Affiche la liste des concerts dans le template concert-index.html.twig
     * 
     * 
     * @param Security $security
     * @param ConcertRepository $concertRepository
     * @param Request $request
     * @param StageRepository $stageRepository
     * @return Response
     * 
     */

    #[Route('/admin/concert', name: 'app_admin_concert')]
    public function index(
        Security $security,
        ConcertRepository $concertRepository,
        Request $request,
        StageRepository $stageRepository
    ): Response
    {

        $selectedStageId = $request->query->get('stage');


        $stages = $stageRepository->findAll();

        if ($selectedStageId) {
            $concerts = $concertRepository->findBy(['Stage' => $selectedStageId]);
            $currentStageName = $stageRepository->find($selectedStageId)->getName();
        } else {
            $concerts = $concertRepository->findBy(['Stage' => $stages[0]->getId()]);
            $currentStageName = $stages[0]->getName();
        }

        $user = $this->getUserInfo($security);


        $startDate = new DateTime($this->getParameter('festival_start_date'));
        $endDate = new DateTime($this->getParameter('festival_end_date'));

        $festivalDuration = $endDate->diff($startDate)->days + 1;

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
            'startDate' => $startDate,
            'duration' => $festivalDuration,
            'stages' => $stages,
            'selectedStageId' => $selectedStageId,
            'currentStageName' => $currentStageName,

        ]);
    }

    /**
     * Route pour créer un nouveau concert
     * Le contrôleur permet de gérer l'ajout d'un concert via un formulaire 
     * Le service SlotCheckerService permet de vérifier si le créneau est déjà pris et renvoie un message d'erreur
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param SlotCheckerService $slotCheckerService
     * @return Response
     */

    #[Route('/admin/concert/new', name: 'app_admin_concert_new')]

    public function add(Security $security, 
    EntityManagerInterface $entityManager, 
    Request $request, 
    SlotCheckerService $slotCheckerService): Response
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
            } else {
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

    /**
     * Route pour éditer un concert
     * Le contrôleur permet de gérer l'édition d'un concert via un formulaire
     * Le service SlotCheckerService permet de vérifier si le créneau est déjà pris et renvoie un message d'erreur
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param Concert $concert
     * @param SlotCheckerService $slotCheckerService
     * @return Response
     * 
     */

    #[Route('/admin/concert/edit/{id}', name: 'app_admin_concert_edit')]

    public function edit(Security $security, 
    EntityManagerInterface $entityManager, 
    Request $request, Concert $concert, 
    SlotCheckerService $slotCheckerService): Response
    {

        $form = $this->createForm(ConcertType::class, $concert);

        $user = $this->getUserInfo($security);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $concertDateTime = $concert->getConcertDate();
            $stageId = $concert->getStage()->getId();

            if ($slotCheckerService->isSlotTaken($concertDateTime, $stageId)) {
                $this->addFlash('danger', 'Ce créneau est déjà pris. Consultez la programmation pour choisir un autre créneau.');
            } else {

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


    /**
     * Route pour supprimer un concert
     * 
     * @param EntityManagerInterface $entityManager
     * @param Concert $concert
     * @return Response
     * 
     */

    #[Route('/admin/concert/delete/{id}', name: 'app_admin_concert_delete')]

    public function delete(EntityManagerInterface $entityManager, 
    Concert $concert): Response
    {

        $entityManager->remove($concert);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_concert');
    }




    /**
     * Route pour afficher la liste des concerts en version publique sous forme de JSON
     * avec un lien vers les images des artistes sous des formats différents (original, 600, 400, 200)
     * pour l'affichage sur le front avec un srcset
     * 
     * 
     * @param ConcertRepository $concertRepository
     * @param JsonResponseNormalizer $jsonResponseNormalizer
     * @return Response
     * 
     */


    #[Route('/api/public/concert', name: 'app_api_concert', methods: ['GET'])]
    public function concert(Request $request, 
    ConcertRepository $concertRepository, 
    JsonResponseNormalizer $jsonResponseNormalizer): Response
    {

        $filterJour = $request->query->get('jour', 'Tout');
        $filterScene = $request->query->get('scene', 'Tout');
        $filterHoraire = $request->query->get('horaire', 'Tout');
        $filterGenre = $request->query->get('genre', 'Tout');

        $criteria = [];

        if ($filterJour !== 'Tout') {
            $criteria['ConcertDate'] = $filterJour;
          
        }

        if ($filterScene !== 'Tout') {
            $criteria['Stage'] = $filterScene;
        }

        if ($filterGenre !== 'Tout') {
            $criteria['Artist.music_style'] = $filterGenre;
        }

     

        $concerts = $concertRepository->findByCriteria($criteria);

        $concertByDay = [];

        foreach ($concerts as $concert) {

            if ($filterJour !== 'Tout' && $concert->getConcertDate()->format('Y-m-d') !== $filterJour) {
                continue;
            }


            $imageName = $concert->getArtist()->getUrlImage();
            $commonPath = 'https://backend.nationsound2024-festival.fr/images/bands/';
            $localPath = './images/bands/';


            $imagesPath = [
                'original' => file_exists($localPath . $imageName) ? $commonPath . $imageName : null,
                '600' => file_exists($localPath . '600-' . $imageName) ? $commonPath . '600-' . $imageName : null,
                '400' => file_exists($localPath . '400-' . $imageName) ? $commonPath . '400-' . $imageName : null,
                '200' => file_exists($localPath . '200-' . $imageName) ? $commonPath . '200-' . $imageName : null,
            ];


            $concertData = [
                'id' => $concert->getId(),
                'date' => $concert->getConcertDate()->format('Y-m-d H:i:s'),
                'location' => $concert->getStage()->getName(),
                'description' => $concert->getArtist()->getDescription(),
                'artist' => $concert->getArtist()->getName(),
                'musicStyle' => $concert->getArtist()->getMusicStyle()->getName(),
                'images' => $imagesPath,
                
            ];

            $day = $concert->getConcertDate()->format('Y-m-d');


            if (!isset($concertByDay[$day])) {
                $concertByDay[$day] = [];
            }

            if ($filterHoraire === 'Tout' || (int)$filterHoraire <= (int)$concert->getConcertDate()->format('H')) {
                $concertByDay[$day][] = $concertData;
            }
        }

        $concerts = $jsonResponseNormalizer->respondSuccess(200, $concertByDay);
      
        
        return $concerts;

   
    }


    /**
     * Route pour afficher les filtres de recherche des concerts en version publique sous forme de JSON
     * 
     * @param JsonResponseNormalizer $jsonResponseNormalizer
     * @param StageRepository $stageRepository
     * @param MusicStyleRepository $musicStyleRepository
     * @return Response
     */

    #[Route('/api/public/concert/filters', name: 'app_api_concert_filters', methods: ['GET'])]

    public function festivalFilters(JsonResponseNormalizer $jsonResponseNormalizer, 
    StageRepository $stageRepository, 
    MusicStyleRepository $musicStyleRepository): Response
    { {
            $startDate = new DateTime($this->getParameter('festival_start_date'));
            $endDate = new DateTime($this->getParameter('festival_end_date'));

            $festivalDuration = $endDate->diff($startDate)->days + 1;

            $days = [];
            $openingTime = '14:00';
            $closingTime = '00:00';

            for ($i = 0; $i < $festivalDuration; $i++) {
                $days[] = [
                    'day' => $i + 1,
                    'date' => $startDate->format('Y-m-d'),
                    'openingTime' => $openingTime,
                    'closingTime' => $closingTime,
                ];
                $startDate->modify('+1 day');
            }




            $musicStyles = $musicStyleRepository->findAll();

            $musicStylesList = [];

            foreach ($musicStyles as $musicStyle) {
                $musicStylesList[] = [
                    'id' => $musicStyle->getId(),
                    'name' => $musicStyle->getName(),
                ];
            }

            $stages = $stageRepository->findAll();

            $stagesList = [];

            foreach ($stages as $stage) {
                $stagesList[] = [
                    'id' => $stage->getId(),
                    'name' => $stage->getName(),
                ];
            }


            $response = [
                'days' => $days,
                'amplitudeHoraire' => [
                    'min' => $openingTime,
                    'max' => $closingTime,
                ],
                'musicStyles' => $musicStylesList,
                'stages' => $stagesList,
            ];

            $response = $jsonResponseNormalizer->respondSuccess(200, $response);
            return $response;
        }
    }

/**
 * Route pour afficher les concerts en cours en version publique sous forme de JSON
 */


    #[Route('/api/public/concert/now', name: 'app_api_concert_now', methods: ['GET'])]

    public function concertNow(ConcertRepository $concertRepository, JsonResponseNormalizer $jsonResponseNormalizer): Response
    {
        $now = new DateTime('2024-06-30 14:00:00');  
        $concerts = $concertRepository->findBy(['ConcertDate' => $now]);

        $concertsList = [];

        foreach ($concerts as $concert) {
            $concertsList[] = [
                'id' => $concert->getId(),
                'date' => $concert->getConcertDate()->format('Y-m-d H:i:s'),
                'location' => $concert->getStage()->getName(),
                'musicStyle' => $concert->getArtist()->getMusicStyle()->getName(),
                'artist' => $concert->getArtist()->getName(),
            ];
        }

        $response = $jsonResponseNormalizer->respondSuccess(200, $concertsList);
        return $response;
    }




}
