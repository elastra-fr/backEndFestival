<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterEditorType;
use App\Repository\UserRepository;
use App\Service\JsonResponseNormalizer;
use App\Service\MailerService;
use App\Service\PasswordValidatorService;
use App\Trait\UserInfoTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Trait\StandardResponsesTrait;


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
 * Route pour reinitaliser le mot de passe de l'utilisateur
 * 
 * @param Request $request
 * @param UserRepository $userRepository
 * @param UserPasswordHasherInterface $userPasswordHasherInterface
 * @param EntityManagerInterface $entityManagerInterface
 * @param JsonResponseNormalizer $jsonResponseNormalizer
 * @return Response
 * 
 */

    #[Route(path: '/reset-password', name: 'app_reset_password', methods: ['POST'])]

    public function resetPassword(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasherInterface, EntityManagerInterface $entityManagerInterface, JsonResponseNormalizer $jsonResponseNormalizer): Response
    {
       /* $data = json_decode($request->getContent(), true);

        $user = $userRepository->findOneBy(['email' => $data['email']]);

        if (!$user) {
            $userNotFoundResponse = $jsonResponseNormalizer->respondError('user_not_found', 'Utilisateur non trouvé !', Response::HTTP_NOT_FOUND);
            return $userNotFoundResponse;
        }

        $temporalPassword = bin2hex(random_bytes(8));

        $user->setPassword($userPasswordHasherInterface->hashPassword($user, $temporalPassword));

        $entityManagerInterface->flush();

        $emailBody = sprintf(
            '       Bonjour %s,<br><p>Votre mot de passe a été réinitialisé avec succès. Voici votre nouveau mot de passe : %s. Vous pouvez le changer à tout moment dans votre profil.</p><br><p>A bientôt sur le festival ! </p><br>      <p>L\'équipe du festival NationSound2024</p>',
            $user->getFirstName(),
            $temporalPassword
        );

        $this->mailerService->sendEmail($user->getEmail(), 'Réinitialisation de votre mot de passe', $emailBody);

        $resetSuccessResponse = $jsonResponseNormalizer->respondSuccess(Response::HTTP_OK, ['message' => 'Mot de passe réinitialisé avec succès !']);
        return $resetSuccessResponse;*/
    }






    /**
     * Route pour afficher les utilisateurs enregistrés ayant le rôle ROLE_EDITOR dans la partie backend
     * 
     * @param Security $security
     * @param UserRepository $userRepository
     * @return Response 
     * 
     */

    #[Route(path: '/admin/user', name: 'app_admin_user')]

    public function index(
        Security $security,
        UserRepository $userRepository
    ): Response {
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
                'isBlocked' => $user->isBlocked(),
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
     * @param Security $security
     * @param RegisterEditorType $registerEditorType
     * @param EntityManagerInterface $entityManagerInterface
     * @param UserPasswordHasherInterface $userPasswordHasherInterface
     * @param MailerService $mailerService
     * @param Request $request
     * @return Response
     */

    #[Route(path: '/admin/user/new', name: 'app_admin_user_new')]

    public function add(
        Security $security,
        EntityManagerInterface $entityManagerInterface,
        UserPasswordHasherInterface $userPasswordHasherInterface,
        MailerService $mailerService,
        Request $request
    ): Response {

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
                '       Bonjour %s,<br><p>Vous venez d\'être inscrit comme éditeur sur le backend NationSound 2024 . 
    Veuillez cliquer sur le lien suivant pour confirmer votre adresse email et choisir votre mot de passe : 
    <a href="%s">Confirmer</a>.</p><br><p>A bientôt sur le festival ! </p><br>      <p>L\'équipe du festival NationSound2024</p>',
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
     * Route pour bloquer un utilisateur ayant le rôle ROLE_EDITOR dans la partie backend
     * 
     * @param EntityManagerInterface $entityManagerInterface
     * @param UserRepository $userRepository
     * @param $id
     * @return Response
     *  
     */

    #[Route(path: '/admin/user/block/{id}', name: 'app_admin_user_block')]

    public function block(EntityManagerInterface $entityManagerInterface, 
    UserRepository $userRepository, $id): Response
    {
        // $CurrentUser = $this->getUserInfo($security);

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $userRepository->find($id);

        if ($user) {
            $user->setBlocked(true);
            $entityManagerInterface->flush();
        }

        return $this->redirectToRoute('app_admin_user');
    }

    /**
     * Route pour débloquer un utilisateur ayant le rôle ROLE_EDITOR dans la partie backend
     * 
     * @param EntityManagerInterface $entityManagerInterface
     * @param UserRepository $userRepository
     * @param $id
     * @return Response
     * 
     */

    #[Route(path: '/admin/user/unblock/{id}', name: 'app_admin_user_unblock')]

    public function unblock(EntityManagerInterface $entityManagerInterface, 
    UserRepository $userRepository, $id): Response
    {
      

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $userRepository->find($id);

        if ($user) {
            $user->setBlocked(false);
            $entityManagerInterface->flush();
        }

        return $this->redirectToRoute('app_admin_user');
    }

    /**
     * Route pour supprimer un utilisateur ayant le rôle ROLE_EDITOR dans la partie backend
     * 
     * @param EntityManagerInterface $entityManagerInterface
     * @param UserRepository $userRepository
     * @param int $id
     * @return Response
     * 
     */

    #[Route(path: '/admin/user/delete/{id}', name: 'app_admin_user_delete')]

    public function delete(EntityManagerInterface $entityManagerInterface, UserRepository $userRepository, int $id): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $userRepository->find($id);

        if ($user) {
            $entityManagerInterface->remove($user);
            $entityManagerInterface->flush();
        }

        return $this->redirectToRoute('app_admin_user');
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

    public function register(Request $request, 
    EntityManagerInterface $entityManager, 
    PasswordValidatorService $passwordValidatorService, 
    UserPasswordHasherInterface $passwordHasher, 
    JsonResponseNormalizer $jsonResponseNormalizer, 
    MailerService $mailerService): Response
    {

        $data = json_decode($request->getContent(), true);

        $user = new User();

        $user->setEmail($data['email']);
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->generateEmailVerificationToken();

        $plainPassword = $data['password'];


        //Verifier si l'email est valide

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {

            $invalidEmailResponse = $jsonResponseNormalizer->respondError('invalid_email', 'Email invalide !', Response::HTTP_BAD_REQUEST);
            return $invalidEmailResponse;
        }


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

        $confirmationLink = $this->generateUrl('confirm_user', ['token' => $user->getEmailVerificationToken()], UrlGeneratorInterface::ABSOLUTE_URL);

        $emailBody = sprintf(
            '       Bonjour %s,<br><p>Votre inscription a été effectuée avec succès. Veuillez cliquer sur le lien suivant pour confirmer votre adresse email : 
            <a href="%s">Confirmer votre adresse email</a>.</p><br><p>A bientôt sur le festival ! </p><br>      <p>L\'équipe du festival NationSound2024</p>',
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

    function profil(Security $security, 
    JsonResponseNormalizer $jsonResponseNormalizer): Response
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
            'newsletter' => $user->isNewsletterConsent(),
            'eventNotification' => $user->isEventAlertConsent(),


        ];

        $profilResponse = $jsonResponseNormalizer->respondSuccess(Response::HTTP_OK, $userInfos);
        return $profilResponse;
    }


//Route pour modifier le profil de l'utilisateur connecté via api REST avec token JWT

    /**
     * Route pour modifier le profil de l'utilisateur connecté via api REST avec token JWT
     * Utilisation de JsonResponseNormalizer pour la normalisation des réponses
     * 
     * @param Security $security
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param JsonResponseNormalizer $jsonResponseNormalizer 
     * @return Response
     * 
     */

    #[Route(path: '/api/user/profil/edit', name: 'app_user_profil_edit', methods: ['PUT'])]

    public function updateProfilUser(Request $request, 
    JsonResponseNormalizer $jsonResponseNormalizer,
    UserRepository $userRepository): Response
{
    $data = json_decode($request->getContent(), true);

    
    $user = $this->getUser();

    if (!$user) {

return $jsonResponseNormalizer->respondError('not_authenticated', 'Vous n\'êtes pas authentifié !', 401);
       
    }

        //Analyser les données reçues et vérifier que seuls les champs autorisés sont modifiés sinon retourner une erreur

        $invalidFields = array_diff(array_keys($data), ['firstName', 'lastName', 'email', 'newsletter', 'eventNotification']);

        if (!empty($invalidFields)) {

            $invalidFieldsResponse= $jsonResponseNormalizer->respondError('BAD_REQUEST', 'Les champs suivants ne peuvent pas être modifiés : ' . implode(', ', $invalidFields), 400);
            return $invalidFieldsResponse;
            
        }

    if (isset($data['firstName'])) {
        $user->setFirstName($data['firstName']);
    }

    if (isset($data['lastName'])) {
        $user->setLastName($data['lastName']);
    }

    if (isset($data['newsletter'])) {
        $user->setNewsletterConsent($data['newsletter']);
    }

    if (isset($data['eventNotification'])) {
        $user->setEventAlertConsent($data['eventNotification']);
    }

//Procédure spéciale pour la modification de l'email

    if (isset($data['email'])) {
        
        // Vérification si l'email existe
        $emailExist = $userRepository->findOneBy(['email' => $data['email']]);

      
         if ($emailExist) {

            $emailExistResponse= $jsonResponseNormalizer->respondError('BAD_REQUEST', 'Cet email est déjà utilisé par un autre utilisateur', 400);
            return $emailExistResponse;}
        //Génération d'un token de vérification d'email

        $user->setNewEmail($data['email']);
        $user->generateEmailChangeToken();

             

        //Envoi d'un email à l'utilisateur à son ancienne adresse pour confirmer si il est bien à l'origine de la demande de modification de l'email avec deux liens : un pour confirmer et un pour annuler

        $emailBody = sprintf(
            'Bonjour %s,<br><p>Vous avez demandé à modifier votre adresse email pour la nouvelle adresse %s. Veuillez cliquer sur le lien suivant pour confirmer votre nouvelle adresse email : <a href="%s">Confirmer votre adresse email</a></p><p>Si vous n\'êtes pas à l\'origine de cette demande, veuillez cliquer sur le lien suivant pour annuler la modification : <a href="%s">Annuler la modification</a></p>', $user->getFirstName(), $user->getNewEmail(),$this->generateUrl('app_confirm_email_change', ['token' => $user->getEmailChangeToken()], UrlGeneratorInterface::ABSOLUTE_URL), $this->generateUrl('app_cancel_email_change', ['token' => $user->getEmailChangeToken()], UrlGeneratorInterface::ABSOLUTE_URL));

        $this->mailerService->sendEmail(
            $user->getEmail(),
            'Modification de votre adresse email',
            $emailBody
        );

        $emailChangeMessage="Un email de confirmation a été envoyé à votre ancienne adresse email. Veuillez cliquer sur le lien qu'il contient pour confirmer la procédure de changement.";

        
      //  $confirmationLink = $this->generateUrl('confirm_email', ['token' => $user->getEmailVerificationToken()], UrlGeneratorInterface::ABSOLUTE_URL);

    }

    $this->manager->persist($user);
    $this->manager->flush();

    $updateSuccessResponse= $this->jsonResponseNormalizer->respondSuccess(200, ['message' => "Utilisateur modifié avec succès", 'emailChangeMessage' => $emailChangeMessage ?? null]);
    return $updateSuccessResponse;

}


    /**
     * Route pour supprimer le profil de l'utilisateur connecté via api REST avec token JWT
     * Utilisation de JsonResponseNormalizer pour la normalisation des réponses
     * 
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param JsonResponseNormalizer $jsonResponseNormalizer
     * @return Response
     * 
     */

    #[Route(path: '/api/user/profil/delete', name: 'app_user_profil_delete', methods: ['DELETE'])]

    function deleteProfil(Security $security, 
    EntityManagerInterface $entityManager, 
    JsonResponseNormalizer $jsonResponseNormalizer): Response
    {

        $user = $security->getUser();

        $role = $user->getRoles();
    //Vérifier si l'utilisateur est authentifié et si il a bien le role ROLE_USER



        if (!$user) {

            $profilResponse = $jsonResponseNormalizer->respondError('not_authenticated', 'Vous n\'êtes pas authentifié !', Response::HTTP_UNAUTHORIZED);
            return $profilResponse;
        }

        if ($role[0] !== 'ROLE_USER') {

            $profilResponse = $jsonResponseNormalizer->respondError('not_authorized', 'Vous n\'êtes pas autorisé à effectuer cette action !', Response::HTTP_FORBIDDEN);
            return $profilResponse;
        }

        $entityManager->remove($user);

        $entityManager->flush();

        $profilResponse = $jsonResponseNormalizer->respondSuccess(Response::HTTP_OK, ['message' => 'Profil supprimé avec succès !']);
        return $profilResponse;

    }

}
