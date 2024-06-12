<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\JsonResponseNormalizer;
use App\Service\MailerService;
use App\Service\PasswordValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Trait\UserInfoTrait;
Use App\Form\RegisterEditorType;

class UserController extends AbstractController
{

use UserInfoTrait;

/**
 * Route pour rediriger les roles USER vers la page d'accueil du frontend en cas de tentative d'accès au backend
 * 
 * @return RedirectResponse
 * 
 */

#[Route(path: '/access-denied', name: 'access_denied')]

public function accessDenied(): Response
{
    return new RedirectResponse('https://www.nationsound2024-festival.fr/home');
}

/**
 * Route pour afficher les utilisateurs enregistrés ayant le rôle ROLE_EDITOR dans la partie backend
 * 
 */

#[Route(path: '/admin/user', name: 'app_admin_user')]

public function index(Security $security, UserRepository $userRepository): Response
{
    $CurrentUser = $this->getUserInfo($security);


    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $users = $userRepository->findByRole('ROLE_EDITOR');

    $usersList = [];

    foreach ($users as $user) {
        $usersList[] = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'isVerified' => $user->isUserVerified(),
        ];
    }

   
    
    return $this->render('user/user-index.html.twig', [
        'controller_name' => 'UserController',
        'firstName' => $CurrentUser['firstName'],
        'role' => $CurrentUser['role'],
        'users' => $usersList,



    ]);
}

/**
 * Route pour afficher le formulaire d'inscription des utilisateurs ayant le rôle ROLE_EDITOR dans la partie backend
 * 
 */

#[Route(path: '/admin/user/new', name: 'app_admin_user_new')]

public function add(Security $security, RegisterEditorType $registerEditorType, EntityManagerInterface $entityManagerInterface, UserPasswordHasherInterface $userPasswordHasherInterface, MailerService $mailerService, Request $request ): Response
{

    $CurrentUser = $this->getUserInfo($security);

    $userToRegister = new User();

    //génerer un token de vérification d'email

    $userToRegister->generateEmailVerificationToken();



    $form = $this->createForm(RegisterEditorType::class, $userToRegister);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $userToRegister->setRoles(['ROLE_EDITOR']);
        
        //Générer un mot de passe aléatoire

        $temporalPassword = bin2hex(random_bytes(8));

        //Hasher le mot de passe

        $userToRegister->setPassword($userPasswordHasherInterface->hashPassword($userToRegister, $temporalPassword));
                
        //Vérifier si l'email existe déjà

        $emailExists = $entityManagerInterface->getRepository(User::class)->findOneBy(['email' => $userToRegister->getEmail()]);
        if ($emailExists) {
            $this->addFlash('danger', 'Cet email existe déjà !');
            return $this->redirectToRoute('app_admin_user_new');
        }



        $entityManagerInterface->persist($userToRegister);
        $entityManagerInterface->flush();

            $confirmationLink = $this->generateUrl('confirm_editor', ['token' => $userToRegister->getEmailVerificationToken()], UrlGeneratorInterface::ABSOLUTE_URL);
      
        $emailBody = sprintf(
    '       Bonjour %s,<br><p>Vous venez d\'être inscrit comme éditeur sur le backend NationSound 2024 . Veuillez cliquer sur le lien suivant pour confirmer votre adresse email et choisir votre mot de passe : <a href="%s">Confirmer</a>.</p><br><p>A bientôt sur le festival ! </p><br>      <p>L\'équipe du festival NationSound2024</p>',
        $userToRegister->getFirstName(),
            $confirmationLink
);

$mailerService->sendEmail($userToRegister->getEmail(), 'Confirmation de votre adresse email', $emailBody);






        return $this->redirectToRoute('app_admin_user');
    }


    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    return $this->render('user/editor-add.html.twig', [
        'controller_name' => 'UserController',
        'firstName' => $CurrentUser['firstName'],
        'lastName' => $CurrentUser['lastName'],
        'role' => $CurrentUser['role'],
        'form' => $form->createView(),
    ]);
}







/**
 * Route pour enregistrer un utilisateur via api REST
 * Utilisation de JsonResponseNormalizer pour la normalisation des réponses
 * Utilisation de MailerService pour l'envoi d'email
 * Utilisation de PasswordValidatorService pour la validation du mot de passe
 * Tous les utilisateurs enregistrés via cette route ont le rôle ROLE_USER
 * 
 * 
 * @param Request $request
 * @param EntityManagerInterface $entityManager
 * @param PasswordValidatorService $passwordValidatorService
 * @param UserPasswordHasherInterface $passwordHasher
 * @param JsonResponseNormalizer $jsonResponseNormalizer
 * @param MailerService $mailerService
 * @return Response
 * 
 
 */

#[Route(path: '/api/user/register', name: 'app_user_register', methods: ['POST'])]

public function register(Request $request, EntityManagerInterface $entityManager, PasswordValidatorService $passwordValidatorService, UserPasswordHasherInterface $passwordHasher, JsonResponseNormalizer $jsonResponseNormalizer, MailerService $mailerService): Response
{
    
    $data = json_decode($request->getContent(), true);

    $user = new User();
    
    $user->setEmail($data['email']);
    $user->setFirstName($data['firstName']);
    $user->setLastName($data['lastName']);
    $user->generateEmailVerificationToken();

    $plainPassword = $data['password'];

    //Verifier si l'email existe déjà

    $emailExists = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);

    if ($emailExists) {

        $emailExistsResponse = $jsonResponseNormalizer->respondError('email_already_exists', 'Cet email existe déjà !', Response::HTTP_CONFLICT);
        return $emailExistsResponse;

       
    }

    //Verifier si le mot de passe est complexe

    $errors = $passwordValidatorService->isPasswordComplex($plainPassword);

    if (!empty($errors)) {

        $badPasswordResponse = $jsonResponseNormalizer->respondError('bad_password', 'Le mot de passe doit contenir ' . implode(', ', $errors) . ' !', Response::HTTP_BAD_REQUEST);
        return $badPasswordResponse;

  
    }


    $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));

    $user->setRoles(['ROLE_USER']);
    $entityManager->persist($user);
    $entityManager->flush();

    $confirmationLink = $this->generateUrl('confirm_email', ['token' => $user->getEmailVerificationToken()], UrlGeneratorInterface::ABSOLUTE_URL);
      
        $emailBody = sprintf(
    '       Bonjour %s,<br><p>Votre inscription a été effectuée avec succès. Veuillez cliquer sur le lien suivant pour confirmer votre adresse email : <a href="%s">Confirmer votre adresse email</a>.</p><br><p>A bientôt sur le festival ! </p><br>      <p>L\'équipe du festival NationSound2024</p>',
        $user->getFirstName(),
            $confirmationLink
);

$mailerService->sendEmail($user->getEmail(), 'Confirmation de votre adresse email', $emailBody);


    //Envoi d'un email de vérification

$successResponse = $jsonResponseNormalizer->respondSuccess(Response::HTTP_CREATED, ['message' => 'Utilisateur enregistré avec succès!']);
return $successResponse;

}

/**
 * Route pour récupérer le profil de l'utilisateur connecté via api REST avec token JWT
 * Utilisation de JsonResponseNormalizer pour la normalisation des réponses
 * 
 * @param Security $security
 * @param JsonResponseNormalizer $jsonResponseNormalizer
 * @return Response
 * 
 */

#[Route(path: '/api/user/profil', name: 'app_user_profil', methods: ['GET'])]

function profil(Security $security, JsonResponseNormalizer $jsonResponseNormalizer): Response
{
 
    $user = $security->getUser();

    if (!$user) {

        $profilResponse = $jsonResponseNormalizer->respondError('not_authenticated', 'Vous n\'êtes pas authentifié !', Response::HTTP_UNAUTHORIZED);
        return $profilResponse;


    }

    $userInfos = [
        'email' => $user->getEmail(),
        'firstName' => $user->getFirstName(),
        'lastName' => $user->getLastName(),

        
    ];

    $profilResponse= $jsonResponseNormalizer->respondSuccess(Response::HTTP_OK, $userInfos);
    return $profilResponse;

}

}
