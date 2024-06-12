<?php

namespace App\Controller;

use App\Entity\Concert;
use App\Form\ConcertType;
use App\Repository\ConcertRepository;
use App\Repository\StageRepository;
use App\Service\JsonResponseNormalizer;
use App\Service\SlotCheckerService;
use App\Trait\UserInfoTrait;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use SebastianBergmann\Timer\Duration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConcertController extends AbstractController
{
    use UserInfoTrait;


/**
 * Affiche la liste des concerts
 * 
 * @param Security $security
 * @param ConcertRepository $concertRepository
 * @return Response
 * 
 */

    #[Route('/admin/concert', name: 'app_admin_concert')]
    public function index(Security $security, ConcertRepository $concertRepository, Request $request, StageRepository $stageRepository): Response
    {

        $selectedStageId = $request->query->get('stage');
 

        $stages = $stageRepository->findAll();

        if ($selectedStageId) {
            $concerts = $concertRepository->findBy(['Stage' => $selectedStageId]);
            //Récupérer le nom de la scène
            $currentStageName = $stageRepository->find($selectedStageId)->getName();
          

        } else {
            $concerts = $concertRepository->findBy(['Stage' => $stages[0]->getId()]);
            $currentStageName = $stages[0]->getName();
        }

        $user = $this->getUserInfo($security);

        //$concerts = $concertRepository->findAll();

        $startDate = new DateTime($this->getParameter('festival_start_date'));
        $endDate = new DateTime($this->getParameter('festival_end_date'));
        //var_dump($startDate);
        //var_dump($endDate);

        $festivalDuration = $endDate->diff($startDate)->days+1;
        //var_dump($festivalDuration);




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

    public function delete(EntityManagerInterface $entityManager, Concert $concert): Response
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


    #[Route('/api/public/concert', name: 'app_api_concert')]
    public function concert(ConcertRepository $concertRepository, JsonResponseNormalizer $jsonResponseNormalizer): Response
    {

        $concerts = $concertRepository->findAll();

        $concertsList = [];



        foreach ($concerts as $concert) {
            $imageName = $concert->getArtist()->getUrlImage();
            $commonPath = 'https://backend.nationsound2024-festival.fr/images/bands/';
            $localPath = './images/bands/';


            $imagesPath = [
                'original' => file_exists($localPath . $imageName) ? $commonPath . $imageName : null,
                '600' => file_exists($localPath . '600-' . $imageName) ? $commonPath . '600-' . $imageName : null,
                '400' => file_exists($localPath . '400-' . $imageName) ? $commonPath . '400-' . $imageName : null,
                '200' => file_exists($localPath . '200-' . $imageName) ? $commonPath . '200-' . $imageName : null,
            ];

            var_dump($localPath . $imageName);


            
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
