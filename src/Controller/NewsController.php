<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use App\Repository\NewsCategoryRepository;
use App\Repository\NewsRepository;
use App\Service\JsonResponseNormalizer;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsController extends AbstractController
{
    use UserInfoTrait;
    /**
     * Route pour la page d'administration des actualités
     * 
     * @param Security $security
     * @param NewsRepository $newsRepository
     * @return Response
     */

    #[Route('/admin/news', name: 'app_admin_news')]
    public function index(
        Security $security,
        NewsRepository $newsRepository,
        NewsCategoryRepository $newsCategoryRepository,
        Request $request
    ): Response {

        $user = $this->getUserInfo($security);

    $newsCategoryFilter = $request->query->get('categoryId');

        $categories = $newsCategoryRepository->findBy([], ['Category' => 'ASC']);

        if ($newsCategoryFilter) {

            $news = $newsRepository->findBy(['NewsCategory' => $newsCategoryFilter], ['news_date' => 'DESC']);
        } else {
            
        $news = $newsRepository->findBy([], ['news_date' => 'DESC']);
        }

        return $this->render('news/index.html.twig', [
            'controller_name' => 'NewsController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'news' => $news,
            'categories' => $categories,
            'categoryFilter' => $newsCategoryFilter,
        ]);
    }

    /**
     * Route pour l'ajout d'une actualité
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */

    #[Route('/admin/news/new', name: 'app_admin_news_new')]

    public function add(
        Security $security,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {

        $news = new News();

        $form = $this->createForm(NewsType::class, $news);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $news->setNewsDate(new \DateTime());

            $entityManager->persist($news);

            $entityManager->flush();


            $enableNotification = $form->get('enable_notification')->getData();

            if ($enableNotification) {

                // Send notification to users

            }


            return $this->redirectToRoute('app_admin_news');
        }

        $user = $this->getUserInfo($security);

        return $this->render('news/add.html.twig', [
            'controller_name' => 'NewsController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),


        ]);
    }


    /**
     * Route pour la suppression d'une actualité
     * 
     * @param EntityManagerInterface $entityManager
     * @param News $news
     * @return Response
     * 
     */

    #[Route('/admin/news/delete/{id}', name: 'app_admin_news_delete')]

    public function delete(
        EntityManagerInterface $entityManager,
        News $news
    ): Response {

        $entityManager->remove($news);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_news');
    }

    /**
     * Route pour l'édition d'une actualité
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param News $news
     * @param Request $request
     * @return Response
     */

    #[Route('/admin/news/edit/{id}', name: 'app_admin_news_edit')]

    public function edit(
        Security $security,
        EntityManagerInterface $entityManager,
        News $news,
        Request $request
    ): Response {
        $form = $this->createForm(NewsType::class, $news);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $news->setNewsDate(new \DateTime());

            $entityManager->persist($news);
            $entityManager->flush();

            $enableNotification = $form->get('enable_notification')->getData();

            if ($enableNotification) {
            }

            return $this->redirectToRoute('app_admin_news');
        }

        $user = $this->getUserInfo($security);

        return $this->render('news/add.html.twig', [
            'controller_name' => 'NewsController',
            'firstName' => $user['firstName'],
            'role' => $user['role'],
            'form' => $form->createView(),
        ]);
    }

    /**
     * Route publique pour les actualités pour les catégories  id 1, 2 et 5 avec envoi d'un paramètre limit 
     * pour limiter le nombre d'actualités à afficher ou 'all' pour afficher toutes les actualités
     *
     * @param NewsRepository $newsRepository
     * @param JsonResponseNormalizer $jsonResponseNormalizer
     * @param Request $request
     * @return Response
     */


    #[Route('/api/public/news', name: 'app_api_public_lastnews')]

    public function lastNews(
        NewsRepository $newsRepository,
        JsonResponseNormalizer $jsonResponseNormalizer,
        Request $request
    ): Response {

        $limit = $request->query->get('limit', 5);

        if ($limit === 'all') {

            $news = $newsRepository->findBy(['NewsCategory' => [1, 2, 5]], ['news_date' => 'DESC']);
        } else {

            $news = $newsRepository->findBy(['NewsCategory' => [1, 2, 5]], ['news_date' => 'DESC'], $limit);
        }




        $lastNews = [];

        foreach ($news as $newsItem) {

            $lastNews[] = [
                'id' => $newsItem->getId(),
                'title' => $newsItem->getTitle(),
                'content' => $newsItem->getNewsContent(),
                'newsDate' => $newsItem->getNewsDate(),
            ];
        }

        $response = $jsonResponseNormalizer->respondSuccess(200, $lastNews);

        return $response;
    }


    /**
     * Route publique pour les actualités pour les catégories  id 3 et 4 qui donneront lieu à une alerte sur le front end
     *
     * @param NewsRepository $newsRepository
     * @param JsonResponseNormalizer $jsonResponseNormalizer
     * @return Response
     */
    #[Route('/api/public/news/alert', name: 'app_api_public_alertnews')]

    public function alertNews(
        NewsRepository $newsRepository,
        JsonResponseNormalizer $jsonResponseNormalizer
    ): Response {

        $news = $newsRepository->findBy(['NewsCategory' => [3, 4]], ['news_date' => 'DESC']);

        $alertNews = [];

        foreach ($news as $newsItem) {

            $alertNews[] = [
                'id' => $newsItem->getId(),
                'title' => $newsItem->getTitle(),
                'content' => $newsItem->getNewsContent(),
                'newsDate' => $newsItem->getNewsDate(),
            ];
        }

        $response = $jsonResponseNormalizer->respondSuccess(200, $alertNews);

        return $response;
    }
}
