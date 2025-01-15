<?php

namespace App\Security;

use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class StatelessCsrfTokenManager implements CsrfTokenManagerInterface
{
    private string $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function getToken(string $tokenId): CsrfToken
    {
        $value = hash_hmac('sha256', $tokenId, $this->secret);
        return new CsrfToken($tokenId, $value);
    }

    public function isTokenValid(CsrfToken $token): bool
    {
        return hash_equals(
            $this->getToken($token->getId())->getValue(),
            $token->getValue()
        );
    }

    public function refreshToken(string $tokenId): CsrfToken
    {
        return $this->getToken($tokenId);
    }

    public function removeToken(string $tokenId): ?string
    {
        return null; // Pas nécessaire pour une implémentation stateless
    }
}
