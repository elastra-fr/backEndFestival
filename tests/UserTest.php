<?php

namespace App\Tests\Controller;

use App\Controller\UserController;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\JsonResponseNormalizer;
use App\Service\MailerService;
use App\Service\PasswordValidatorService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserTest extends TestCase
{
    private $security;
    private $entityManager;
    private $userRepository;
    private $passwordHasher;
    private $mailerService;
    private $jsonResponseNormalizer;
    private $passwordValidatorService;
    private $urlGenerator;
    private $userController;

    protected function setUp(): void
    {
        $this->security = $this->createMock(Security::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $this->mailerService = $this->createMock(MailerService::class);
        $this->jsonResponseNormalizer = $this->createMock(JsonResponseNormalizer::class);
        $this->passwordValidatorService = $this->createMock(PasswordValidatorService::class);
        $this->urlGenerator = $this->createMock(UrlGeneratorInterface::class);

        $this->userController = $this->getMockBuilder(UserController::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['generateUrl'])
            ->getMock();

        $this->userController->method('generateUrl')
            ->willReturn('http://example.com/confirm');
    }

    public function testRegister()
    {
        $request = $this->createMock(Request::class);
        $request->method('getContent')->willReturn(json_encode([
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
            'password' => 'StrongPassword123!'
        ]));

        $this->passwordValidatorService->method('isPasswordComplex')->willReturn([]);
        
        $this->entityManager->expects($this->once())->method('persist');
        $this->entityManager->expects($this->once())->method('flush');

        $expectedJsonResponse = new JsonResponse(['message' => 'Utilisateur enregistré avec succès!'], JsonResponse::HTTP_CREATED);
        $this->jsonResponseNormalizer->method('respondSuccess')
            ->willReturn($expectedJsonResponse);

        $response = $this->userController->register(
            $request,
            $this->entityManager,
            $this->passwordValidatorService,
            $this->passwordHasher,
            $this->jsonResponseNormalizer,
            $this->mailerService
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertJson($response->getContent());
       $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Utilisateur enregistré avec succès!', $responseData['message']);
    }

  public function testProfil()
    {
        // Créer un mock pour l'utilisateur
        $user = $this->createMock(User::class);
        $user->method('getEmail')->willReturn('test@example.com');
        $user->method('getFirstName')->willReturn('John');
        $user->method('getLastName')->willReturn('Doe');
        $user->method('isNewsletterConsent')->willReturn(true);
        $user->method('isEventAlertConsent')->willReturn(false);

        // Configurer le mock Security pour retourner l'utilisateur mock
        $this->security->method('getUser')->willReturn($user);

        // Créer la réponse JSON attendue
        $expectedResponse = new JsonResponse([
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
            'newsletter' => true,
            'eventNotification' => false,
        ], JsonResponse::HTTP_OK);

        // Configurer le JsonResponseNormalizer mock
        $this->jsonResponseNormalizer->method('respondSuccess')
            ->willReturn($expectedResponse);

        // Appeler la méthode profil
        $response = $this->userController->profil(
            $this->security,
            $this->jsonResponseNormalizer
        );

        // Vérifier que la réponse est une instance de JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $response);

        // Vérifier le code de statut
        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());

        // Vérifier le contenu de la réponse
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('email', $responseData);
        $this->assertArrayHasKey('firstName', $responseData);
        $this->assertArrayHasKey('lastName', $responseData);
        $this->assertArrayHasKey('newsletter', $responseData);
        $this->assertArrayHasKey('eventNotification', $responseData);

        $this->assertEquals('test@example.com', $responseData['email']);
        $this->assertEquals('John', $responseData['firstName']);
        $this->assertEquals('Doe', $responseData['lastName']);
        $this->assertTrue($responseData['newsletter']);
        $this->assertFalse($responseData['eventNotification']);
    }



    public function testRegisterWithInvalidPassword()
{
    $request = $this->createMock(Request::class);
    $request->method('getContent')->willReturn(json_encode([
        'email' => 'test@example.com',
        'firstName' => 'John',
        'lastName' => 'Doe',
        'password' => 'weak'
    ]));

    $this->passwordValidatorService->method('isPasswordComplex')
        ->willReturn(['Le mot de passe doit contenir au moins 8 caractères']);

    $expectedJsonResponse = new JsonResponse(
        ['errors' => ['Le mot de passe doit contenir au moins 8 caractères']],
        JsonResponse::HTTP_BAD_REQUEST
    );
    $this->jsonResponseNormalizer->method('respondError')
        ->willReturn($expectedJsonResponse);

    $response = $this->userController->register(
        $request,
        $this->entityManager,
        $this->passwordValidatorService,
        $this->passwordHasher,
        $this->jsonResponseNormalizer,
        $this->mailerService
    );

    $this->assertInstanceOf(JsonResponse::class, $response);
    $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    $responseData = json_decode($response->getContent(), true);
    $this->assertArrayHasKey('errors', $responseData);
}



public function testProfilWithUnauthenticatedUser()
{
    $this->security->method('getUser')->willReturn(null);

    $expectedJsonResponse = new JsonResponse(
        ['error' => 'Utilisateur non authentifié'],
        JsonResponse::HTTP_UNAUTHORIZED
    );
    $this->jsonResponseNormalizer->method('respondError')
        ->willReturn($expectedJsonResponse);

    $response = $this->userController->profil(
        $this->security,
        $this->jsonResponseNormalizer
    );

    $this->assertInstanceOf(JsonResponse::class, $response);
    $this->assertEquals(JsonResponse::HTTP_UNAUTHORIZED, $response->getStatusCode());
    $responseData = json_decode($response->getContent(), true);
    $this->assertArrayHasKey('error', $responseData);
}
/*
public function testUpdateProfil()
    {
        $user = $this->createMock(User::class);
        $this->security->method('getUser')->willReturn($user);

        $request = $this->createMock(Request::class);
        $request->method('getContent')->willReturn(json_encode([
            'firstName' => 'UpdatedJohn',
            'lastName' => 'UpdatedDoe',
            'newsletter' => false,
            'eventNotification' => true
        ]));

        $user->expects($this->once())->method('setFirstName')->with('UpdatedJohn');
        $user->expects($this->once())->method('setLastName')->with('UpdatedDoe');
        $user->expects($this->once())->method('setNewsletterConsent')->with(false);
        $user->expects($this->once())->method('setEventAlertConsent')->with(true);

        $this->entityManager->expects($this->once())->method('flush');

        $expectedJsonResponse = new JsonResponse(['message' => 'Profil mis à jour avec succès'], JsonResponse::HTTP_OK);
        $this->jsonResponseNormalizer->method('respondSuccess')
            ->willReturn($expectedJsonResponse);

        $response = $this->userController->updateProfile(
            $request,
            $this->security,
            $this->entityManager,
            $this->jsonResponseNormalizer
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $responseData);
    }

*/




}