<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Service\PasswordValidatorService;
use App\Service\JsonResponseNormalizer;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Service\MailerService;

class UserController extends AbstractController
{


#[Route(path: '/access-denied', name: 'access_denied')]

public function accessDenied(): Response
{
    return new RedirectResponse('https://www.nationsound2024-festival.fr/home');
}
/***Routes utilisées dans le cadre de l'API JWT par les utilisateurs du front end pour s'enregister, se connecter et modifier leur profil et préférence */

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

        //return $this->json(['message' => 'Cet email existe déjà !'], Response::HTTP_CONFLICT);
    }

    //Verifier si le mot de passe est complexe

    $errors = $passwordValidatorService->isPasswordComplex($plainPassword);

    if (!empty($errors)) {

        $badPasswordResponse = $jsonResponseNormalizer->respondError('bad_password', 'Le mot de passe doit contenir ' . implode(', ', $errors) . ' !', Response::HTTP_BAD_REQUEST);
        return $badPasswordResponse;

        //return $this->json(['message' => 'Le mot de passe doit contenir ' . implode(', ', $errors) . ' !'], Response::HTTP_BAD_REQUEST);
    }


    $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));

    $user->setRoles(['ROLE_USER']);
    //$user->generateEmailVerificationToken();
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
//return $this->json(['message' => 'Utilisateur enregistré !'], Response::HTTP_CREATED);


}

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

//    return $this->json($user, 200, [], ['groups' => 'profil']);




}




}
