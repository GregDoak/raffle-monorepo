<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Token\ValueObject;

enum Context: string
{
    case UsernamePassword = 'USERNAME_PASSWORD';
    case RefreshToken = 'REFRESH_TOKEN';

    public function isGlobalSelector(): bool
    {
        return match ($this) {
            self::UsernamePassword, self::RefreshToken => true,
        };
    }

    public function isAccountSelector(): bool
    {
        return match (true) {
            $this->isGlobalSelector() => false,
            default => true,
        };
    }
}
