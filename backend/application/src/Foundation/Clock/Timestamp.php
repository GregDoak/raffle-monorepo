<?php

declare(strict_types=1);

namespace App\Foundation\Clock;

use DateTimeImmutable;
use Throwable;

final readonly class Timestamp
{
    private function __construct(
        private DateTimeImmutable $dateTime,
    ) {
    }

    public static function now(): self
    {
        return new self(new DateTimeImmutable());
    }

    public static function fromString(string $value): self
    {
        if ($value === '') {
            throw InvalidTimestamp::fromEmpty();
        }

        try {
            return new self(new DateTimeImmutable($value));
        } catch (Throwable) {
            throw InvalidTimestamp::fromInvalid();
        }
    }

    public static function fromNullable(?string $value): ?self
    {
        return $value !== null ? self::fromString($value) : null;
    }

    public function toString(): string
    {
        return $this->dateTime->format('Y-m-d H:i:s.u O');
    }
}
