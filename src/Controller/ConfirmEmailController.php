<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\JsonResponseNormalizer;
use App\Trait\StandardResponsesTrait;
use App\Form\ResetPasswordType;
use App\Service\PasswordValidatorService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;



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
    public function __construct(EntityManagerInterface $manager, UserRepository $userRepository, JsonResponseNormalizer $jsonResponseNormalizer, PasswordValidatorService $passwordValidatorService, UserPasswordHasherInterface $passwordHasher)
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

    #[Route('/confirm-email/{token}', name: 'confirm_email', methods: ['GET'])]
    public function confirmEmail(string $token): Response
    {
        $user = $this->userRepository->findOneBy(['email_verification_token' => $token]);

        if (!$user) {
            return $this->respondInvalidToken();
        }

        $user->setUserVerified(true);
        $user->setEmailVerificationToken(null);

        $this->manager->persist($user);
        $this->manager->flush();
        return $this->respondConfirmedEmail();
    }

//Méthode pour confirmer l'inscription des éditeurs et le demander de choir un mot de passe via un formulaire
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

            $data=$form->getData();

            $plainPassword = $data['newPassword'];

            $passwordErrors = $this->passwordValidatorService->isPasswordComplex($plainPassword);

            if(!empty($passwordErrors)){
        $this->addFlash('error', 'Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial. Veuillez respecter les critères suivants : ' . implode(', ', $passwordErrors) . ' !');   
            }

            $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);

            $user->setPassword($hashedPassword);
            $user->setUserVerified(true);
            $user->setEmailVerificationToken(null);


            $this->manager->persist($user);
            $this->manager->flush();
            
            //Redirection vers la page de connexion
            return $this->redirectToRoute('app_admin_login');
        }
        
        
        return $this->render('reset_password/reset-password.html.twig', [
            'form' => $form->createView()
        ]);
        




    }











}
