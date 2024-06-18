<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;


class IsResetInProgressService
{
    
    private Security $security;

/**
 * IsResetInProgressService constructor.
 *
 * @param Security $security
 */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

/**
 * Service pour vérifier si l'utilisateur est connecté et si son mot de passe est en cours de réinitialisation
 *
 * @return boolean
 */
    public function isResetInProgress(): bool
    {
                /** @var User|null $user */
        $user = $this->security->getUser();

        if (!$user) {
            return false;
        }

        return $user->isPasswordResetInProgress();
    }







}