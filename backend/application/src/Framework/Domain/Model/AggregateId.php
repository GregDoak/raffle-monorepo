<?php

declare(strict_types=1);

namespace App\Framework\Domain\Model;

use App\Foundation\Uuid\Uuid;
use App\Framework\Domain\Exception\InvalidAggregateId;

abstract readonly class AggregateId
{
    final private function __construct(
        private string $id,
    ) {
        if (Uuid::isValid($id) === false) {
            throw InvalidAggregateId::fromInvalidId(static::getAggregateName()->toString());
        }
    }

    abstract protected static function getAggregateName(): AggregateName;

    public static function fromNew(): static
    {
        return new static(Uuid::v7());
    }

    public static function fromString(string $id): static
    {
        return new static($id);
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function equals(AggregateId $that): bool
    {
        return $this->id === $that->toString();
    }
}
