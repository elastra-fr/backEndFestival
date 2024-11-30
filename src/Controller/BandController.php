<?php
namespace App\Controller;

use App\Entity\Band;
use App\Form\BandType;
use App\Repository\BandRepository;
use App\Repository\MusicStyleRepository;
use App\Service\DeleteImagesService;
use App\Service\FileUploaderService;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BandController extends AbstractController
{
    use UserInfoTrait;

    /**
     * Affiche la liste des groupes/artistes
     *
     * @param Security $security
     * @param BandRepository $bandRepository
     * @param MusicStyleRepository $musicStyleRepository
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/band', name: 'app_admin_band')]
    public function index(
        Security $security,
        BandRepository $bandRepository,
        MusicStyleRepository $musicStyleRepository,
        Request $request
    ): Response {
        $user = $this->getUserInfo($security);

        $styleFilter = $request->query->get('styleId');

        $styles = $musicStyleRepository->findBy([], ['musicStyleName' => 'ASC']);

        if ($styleFilter) {
            $bands = $bandRepository->findBy(['musicStyle' => $styleFilter], ['bandName' => 'ASC']);
        } else {
            $bands = $bandRepository->findBy([], ['bandName' => 'ASC']);
        }

        return $this->render('band/band-index.html.twig', [
            'controller_name' => 'BandController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'bands' => $bands,
            'styles' => $styles,
            'styleFilter' => $styleFilter,
        ]);
    }

    /**
     * Route pour créer un nouveau groupe/artiste
     *
     * @param Security $security
     * @param EntityManagerInterface $entityManagerInterface
     * @param Request $request
     * @param FileUploaderService $fileUploaderService
     * @return Response
     */
    #[Route('/admin/band/new', name: 'app_admin_band_new')]
    public function add(
        Security $security,
        EntityManagerInterface $entityManagerInterface,
        Request $request,
        FileUploaderService $fileUploaderService
    ): Response {
        $band = new Band();
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);
        $user = $this->getUserInfo($security);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();

            if ($file) {
                $targetDirectory = $this->getParameter('upload_bands_directory');
                $fileName = $fileUploaderService->upload($file, $targetDirectory);
                $band->setBandImage($fileName);
            }

            $entityManagerInterface->persist($band);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_admin_band');
        }

        return $this->render('band/band-add.html.twig', [
            'controller_name' => 'BandController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }

    /**
     * Route pour effacer un groupe/artiste
     *
     * @param EntityManagerInterface $entityManagerInterface
     * @param Band $band
     * @param DeleteImagesService $deleteImagesService
     * @return Response
     */
    #[Route('/admin/band/delete/{id}', name: 'app_admin_band_delete')]
    public function delete(
        EntityManagerInterface $entityManagerInterface,
        Band $band,
        DeleteImagesService $deleteImagesService
    ): Response {
        try {
            $imageName = $band->getUrlImage();
            $directory = $this->getParameter('upload_bands_directory');
            $deleteImagesService->deleteImages($imageName, $directory);

            $entityManagerInterface->remove($band);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_admin_band');
        } catch (\Exception $e) {
            $this->addFlash('danger', 'Erreur lors de la suppression du groupe - Veuillez vérifier qu\'il n\'est pas associé à un événement');
            return $this->redirectToRoute('app_admin_band');
        }
    }

    /**
     * Route pour éditer un groupe/artiste
     *
     * @param Security $security
     * @param EntityManagerInterface $entityManagerInterface
     * @param Request $request
     * @param Band $band
     * @param FileUploaderService $fileUploaderService
     * @param DeleteImagesService $deleteImagesService
     * @return Response
     */
    #[Route('/admin/band/edit/{id}', name: 'app_admin_band_edit')]
    public function edit(
        Security $security,
        EntityManagerInterface $entityManagerInterface,
        Request $request,
        Band $band,
        FileUploaderService $fileUploaderService,
        DeleteImagesService $deleteImagesService
    ): Response {
        $form = $this->createForm(BandType::class, $band);
        $user = $this->getUserInfo($security);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();

            if ($file) {
                $targetDirectory = $this->getParameter('upload_bands_directory');
                $imageName = $band->getBandImage();
                $deleteImagesService->deleteImages($imageName, $targetDirectory);
                $fileName = $fileUploaderService->upload($file, $targetDirectory);
                $band->setBandImage($fileName);
            }

            $entityManagerInterface->persist($band);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_admin_band');
        }

        $currentImageName = $band->getBandImage();
        $currentImagePath = './images/bands/' . $currentImageName;

        return $this->render('band/band-edit.html.twig', [
            'controller_name' => 'BandController',
            'form' => $form->createView(),
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'urlImage' => $currentImagePath,
        ]);
    }
}