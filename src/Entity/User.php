<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email_verification_token = null;

    #[ORM\Column]
    private bool $UserVerified = false;

    #[ORM\Column]
    private ?bool $IsBlocked = false;

    #[ORM\Column]
    private ?int $LoginAttempt = 0;

    #[ORM\Column]
    private ?bool $NewsletterConsent = false;

    #[ORM\Column]
    private ?bool $EventAlertConsent = false;

    #[ORM\Column]
    private ?bool $passwordResetInProgress = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $passwordResetToken = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $newEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emailChangeToken = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    
    public function generateEmailVerificationToken(): self
    {
        $this->email_verification_token = bin2hex(random_bytes(32));
        return $this;
    }

    public function getEmailVerificationToken(): ?string
    {
        return $this->email_verification_token;
    }

    public function setEmailVerificationToken(?string $email_verification_token): static
    {
        $this->email_verification_token = $email_verification_token;

        return $this;
    }

    public function isUserVerified(): ?bool
    {
        return $this->UserVerified;
    }

    public function setUserVerified(bool $UserVerified): static
    {
        $this->UserVerified = $UserVerified;

        return $this;
    }

    public function isBlocked(): ?bool
    {
        return $this->IsBlocked;
    }

    public function setBlocked(bool $IsBlocked): static
    {
        $this->IsBlocked = $IsBlocked;

        return $this;
    }

    public function getLoginAttempt(): ?int
    {
        return $this->LoginAttempt;
    }

    public function setLoginAttempt(int $LoginAttempt): static
    {
        $this->LoginAttempt = $LoginAttempt;

        return $this;
    }

    public function isNewsletterConsent(): ?bool
    {
        return $this->NewsletterConsent;
    }

    public function setNewsletterConsent(bool $NewsletterConsent): static
    {
        $this->NewsletterConsent = $NewsletterConsent;

        return $this;
    }

    public function isEventAlertConsent(): ?bool
    {
        return $this->EventAlertConsent;
    }

    public function setEventAlertConsent(bool $EventAlertConsent): static
    {
        $this->EventAlertConsent = $EventAlertConsent;

        return $this;
    }

    public function isPasswordResetInProgress(): ?bool
    {
        return $this->passwordResetInProgress;
    }

    public function setPasswordResetInProgress(bool $passwordResetInProgress): static
    {
        $this->passwordResetInProgress = $passwordResetInProgress;

        return $this;
    }

    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    public function setPasswordResetToken(?string $passwordResetToken): static
    {
        $this->passwordResetToken = $passwordResetToken;

        return $this;
    }

public function generatePasswordResetToken(): self
    {
        $this->passwordResetToken = bin2hex(random_bytes(32));
        return $this;
    }

public function getNewEmail(): ?string
{
    return $this->newEmail;
}

public function setNewEmail(?string $newEmail): static
{
    $this->newEmail = $newEmail;

    return $this;
}

public function getEmailChangeToken(): ?string
{
    return $this->emailChangeToken;
}

public function setEmailChangeToken(?string $emailChangeToken): static
{
    $this->emailChangeToken = $emailChangeToken;

    return $this;
}

public function generateEmailChangeToken(): self
{
    $this->emailChangeToken = bin2hex(random_bytes(32));
    return $this;

}

}