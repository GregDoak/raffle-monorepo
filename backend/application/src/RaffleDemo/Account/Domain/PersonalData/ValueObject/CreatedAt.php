<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\PersonalData\ValueObject;

use App\Foundation\Clock\Timestamp;

final readonly class CreatedAt
{
    private function __construct(
        private Timestamp $value,
    ) {
    }

    public static function fromNew(): self
    {
        return new self(Timestamp::now());
    }

    public static function fromString(string $value): self
    {
        return new self(Timestamp::fromString($value));
    }

    public function toString(): string
    {
        return $this->value->toString();
    }
}
