<?php

namespace App\Controller;

use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Service\JsonResponseNormalizer;
use App\Service\PasswordValidatorService;
use App\Trait\StandardResponsesTrait;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Service\MailerService;


class ConfirmEmailController extends AbstractController
{

    use StandardResponsesTrait;
    private EntityManagerInterface $manager;
    private UserRepository $userRepository;

    private JsonResponseNormalizer $jsonResponseNormalizer;

    private PasswordValidatorService $passwordValidatorService;

    private UserPasswordHasherInterface $passwordHasher;


    /**
     * ConfirmEmailController constructor.
     *
     * @param EntityManagerInterface $manager
     * @param UserRepository $userRepository
     */
    public function __construct(EntityManagerInterface $manager, 
    UserRepository $userRepository, 
    JsonResponseNormalizer $jsonResponseNormalizer, 
    PasswordValidatorService $passwordValidatorService, 
    UserPasswordHasherInterface $passwordHasher)
    {
        $this->manager = $manager;
        $this->userRepository = $userRepository;
        $this->jsonResponseNormalizer = $jsonResponseNormalizer;
        $this->passwordValidatorService = $passwordValidatorService;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Cette méthode permet de confirmer l'adresse email d'un utilisateur
     * @param string $token : le token de vérification
     * @return JsonResponse : la réponse HTTP
     */

    #[Route('/confirm-editor/{token}', name: 'confirm_editor', methods: ['GET', 'POST'])]
    public function confirmEditor(string $token, Request $request): Response
    {
        $user = $this->userRepository->findOneBy(['email_verification_token' => $token]);

        if (!$user) {
            return $this->respondInvalidToken();
        }

        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $plainPassword = $data['newPassword'];

            $passwordErrors = $this->passwordValidatorService->isPasswordComplex($plainPassword);

            if (!empty($passwordErrors)) {
                $this->addFlash('error', 'Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial. Veuillez respecter les critères suivants : ' . implode(', ', $passwordErrors) . ' !');
            } else {
                $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);

                $user->setPassword($hashedPassword);
                $user->setUserVerified(true);
                $user->setEmailVerificationToken(null);

                $this->manager->persist($user);
                $this->manager->flush();

                // Redirection vers la page de connexion
                return $this->redirectToRoute('app_admin_login');
            }
        }

        return $this->render('reset_password/reset-password.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * Cette méthode permet de confirmer l'adresse email d'un utilisateur
     * @param string $token 
     * @return JsonResponse 
     */

    #[Route('/confirm-user/{token}', name: 'confirm_user')]

    public function confirmUser(string $token, JsonResponseNormalizer $jsonResponseNormalizer): Response
    {
        $user = $this->userRepository->findOneBy(['email_verification_token' => $token]);

        if (!$user) {
            return $this->respondInvalidToken();
        }

        $user->setUserVerified(true);
        $user->setEmailVerificationToken(null);

        $this->manager->persist($user);
        $this->manager->flush();

        return $jsonResponseNormalizer->respondSuccess(200, 'Votre adresse email a été vérifiée avec succès !');
    }

    //Route pour reinialiser le mot de passe

    #[Route('/reset-password/{token}', name: 'reset_password', methods: ['GET', 'POST'])]

    public function resetPassword(string $token, Request $request): Response
    {
        $user = $this->userRepository->findOneBy(['passwordResetToken' => $token]);

        if (!$user) {
            return $this->respondInvalidToken();
        }

        

        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $plainPassword = $data['newPassword'];

            $passwordErrors = $this->passwordValidatorService->isPasswordComplex($plainPassword);

            if (!empty($passwordErrors)) {
                $this->addFlash('error', 'Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial. Veuillez respecter les critères suivants : ' . implode(', ', $passwordErrors) . ' !');
            } else {
                $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);

                $user->setPassword($hashedPassword);
                $user->setPasswordResetInProgress(false);
                $user->setLoginAttempt(0);
                $user->setPasswordResetToken(null);

                $this->manager->persist($user);
                $this->manager->flush();

                $response = $this->jsonResponseNormalizer->respondSuccess(200, 'Votre mot de passe a été réinitialisé avec succès !');
                return $response;


            }
        }

        return $this->render('reset_password/reset-password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet à l'utilisateur de confirmer le changement d'email en cliquant sur le lien reçu par email après avoir demandé un changement d'email
     *
     * @param string $token
     * @return Response
     */

    #[Route('/email/change/confirm/{token}', name: 'app_confirm_email_change')]

    public function confirmEmailChange(string $token,
    MailerService $mailerService,
    JsonResponseNormalizer $jsonResponseNormalizer,
    UserRepository $userRepository
    ): Response
    {

        $user = $this->userRepository->findOneBy(['emailChangeToken' => $token]);

        if (!$user) {
       return $this->respondInvalidToken();
        }

        $user->setEmail($user->getNewEmail());
        $user->setNewEmail(null);
        $user->setEmailChangeToken(null);
        $user->setUserVerified(false);
        $user->setEmailVerificationToken(bin2hex(random_bytes(32)));
        $this->manager->persist($user);
        $this->manager->flush();

        $newEmailConfirmationLink = $this->generateUrl('confirm_user', ['token' => $user->getEmailVerificationToken()], UrlGeneratorInterface::ABSOLUTE_URL);
        $emailBody = sprintf(
            'Bonjour %s,<br><p>Votre inscription a été effectuée avec succès. Veuillez cliquer sur le lien suivant pour confirmer votre adresse email : <a href="%s">Confirmer votre adresse email</a></p>',
            $user->getFirstName(),
            $newEmailConfirmationLink
        );

        $mailerService->sendEmail(
            $user->getEmail(),
            'Inscription réussie',
            $emailBody

        );

     return $this->respondEmailChangeSuccess();
    }


    /**
     * Permet à l'utilisateur d'annuler le changement d'email en cliquant sur le lien reçu par email s'il n'est pas à l'origine de la demande de changement d'email. 
     * L'annulation du changement d'email déclenche un reset du mot de passe par mesure de sécurité
     * @param string $token
     * @return Response
     */

    #[Route('/email/change/cancel/{token}', name: 'app_cancel_email_change')]

    public function cancelEmailChange(string $token,
    MailerService $mailerService,
    JsonResponseNormalizer $jsonResponseNormalizer,
    UserRepository $userRepository
    ): Response
    {

        $user = $this->userRepository->findOneBy(['emailChangeToken' => $token]);

        if (!$user) {
            return $this->respondInvalidToken();
        }

        $user->setEmailChangeToken(null);
        $user->setNewEmail(null);

        //Déclenchement d'un reset du password par mesure de sécurité

        $user->setPasswordResetInProgress(true);
        $user->generatePasswordResetToken();

        $confirmationLink = $this->generateUrl('reset_password', ['token' => $user->getPasswordResetToken()], UrlGeneratorInterface::ABSOLUTE_URL);

        $mailerService->sendEmail(
            $user->getEmail(),
            'Changement d\'email annulé',
            'Votre demande de changement d\'email a été annulée. Pour des raisons de sécurité, nous vous devez réinitialiser votre mot de passe en cliquant sur le lien suivant : <a href="' . $confirmationLink . '">Réinitialiser votre mot de passe</a>'
        );


        $this->manager->persist($user);
        $this->manager->flush();

        $cancelResponse = $jsonResponseNormalizer->respondSuccess(200, ['message' => 'Changement d\'email annulé. Par mesure de sécurité nous vous demandons de reinitialiser votre mot de passe. Veuillez consulter vos emails et suivre la procédure']);
        return $cancelResponse;
    }



}
