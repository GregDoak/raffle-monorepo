<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\Security;

interface UserProvider
{
    public function getUser(): User;
}
