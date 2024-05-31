<?php

namespace App\Trait;

use Symfony\Bundle\SecurityBundle\Security;

trait UserInfoTrait
{
    private function getUserInfo(Security $security): array
    {
        $user = $security->getUser();
        $firstName = $user ? $user->getFirstName() : 'Guest';
        $lastName = $user ? $user->getLastName() : 'User';
        $role = $user ? $user->getRoles()[0] : 'ROLE_USER';

        return [
            'firstName' => $firstName,
            'role' => $role,
            'lastName' => $lastName
        ];
    }
}
