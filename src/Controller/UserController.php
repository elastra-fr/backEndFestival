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


class UserController extends AbstractController
{


/***Routes utilisées dans le cadre de l'API JWT par les utilisateurs du front end pour s'enregister, se connecter et modifier leur profil et préférence */

#[Route(path: '/api/user/register', name: 'app_user_register', methods: ['POST'])]

public function register(Request $request, EntityManagerInterface $entityManager, PasswordValidatorService $passwordValidatorService, UserPasswordHasherInterface $passwordHasher): Response
{
    
    $data = json_decode($request->getContent(), true);

    $user = new User();
    
    $user->setEmail($data['email']);
    $user->setFirstName($data['firstName']);
    $user->setLastName($data['lastName']);

    $plainPassword = $data['password'];

    //Verifier si l'email existe déjà

    $emailExists = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);

    if ($emailExists) {
        return $this->json(['message' => 'Cet email existe déjà !'], Response::HTTP_CONFLICT);
    }

    //Verifier si le mot de passe est complexe

    $errors = $passwordValidatorService->isPasswordComplex($plainPassword);

    if (!empty($errors)) {
        return $this->json(['message' => 'Le mot de passe doit contenir ' . implode(', ', $errors) . ' !'], Response::HTTP_BAD_REQUEST);
    }


    $user->setPassword($this->$passwordHasher->encodePassword($user, $data['password']));
    $user->setRoles(['ROLE_USER']);
    $this->$entityManager->persist($user);
    $this->$entityManager->flush();
    return $this->json(['message' => 'Utilisateur créé avec succès !'], Response::HTTP_CREATED);

}






}
