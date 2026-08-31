<?php

declare(strict_types=1);

namespace App\Framework\Domain\ValueObject;

use App\Foundation\Clock\Timestamp;

/**
 * @phpstan-consistent-constructor
 */
abstract readonly class AbstractNullableTimestamp
{
    protected function __construct(
        private ?Timestamp $value,
    ) {
    }

    public static function fromNew(): static
    {
        return new static(Timestamp::now());
    }

    public static function fromNull(): static
    {
        return new static(null);
    }

    public static function fromNullableString(?string $value): static
    {
        return new static(Timestamp::fromNullable($value));
    }

    public function toString(): ?string
    {
        return $this->value?->toString();
    }
}
