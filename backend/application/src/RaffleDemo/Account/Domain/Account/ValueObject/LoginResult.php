<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Account\ValueObject;

use App\Foundation\Clock\Timestamp;
use App\RaffleDemo\Account\Domain\Token\ValueObject\Context;

final readonly class LoginResult
{
    private function __construct(
        public LoginResultType $type,
        public Context $context,
        public Timestamp $occurredAt,
    ) {
    }

    public static function fromSuccessful(
        Context $context,
        Timestamp $occurredAt,
    ): self {
        return new self(
            type: LoginResultType::Succeeded,
            context: $context,
            occurredAt: $occurredAt,
        );
    }

    public function isSuccessful(): bool
    {
        return match ($this->type) {
            LoginResultType::Succeeded => true,
        };
    }
}
