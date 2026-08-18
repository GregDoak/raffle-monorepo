<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\Security;

final readonly class AnonymousUser implements User
{
    public function __construct(
        private string $userIdentifier,
    ) {
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    /** @return string[] */
    public function getRoles(): array
    {
        return ['ROLE_ANONYMOUS_USER'];
    }
}
