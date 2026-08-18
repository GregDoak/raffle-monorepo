<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\Security;

final readonly class ApiUser implements User
{
    /** @param  string[] $additionalRoles */
    public function __construct(
        private string $userIdentifier,
        private array $additionalRoles = [],
    ) {
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    /** @return string[] */
    public function getRoles(): array
    {
        return array_merge(['ROLE_API_USER'], $this->additionalRoles);
    }
}
