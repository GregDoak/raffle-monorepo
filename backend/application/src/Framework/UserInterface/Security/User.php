<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\Security;

interface User
{
    public function getUserIdentifier(): string;

    /** @return string[] */
    public function getRoles(): array;
}
