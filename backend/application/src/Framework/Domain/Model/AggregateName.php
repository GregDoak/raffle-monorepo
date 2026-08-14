<?php

declare(strict_types=1);

namespace App\Framework\Domain\Model;

use App\Framework\Domain\Exception\InvalidDomainName;

use function trim;

abstract readonly class AggregateName
{
    final private function __construct(
        private string $name,
    ) {
        if (trim($name) === '') {
            throw InvalidDomainName::fromEmptyName(static::class);
        }
    }

    public static function fromString(string $name): static
    {
        return new static($name);
    }

    public function toString(): string
    {
        return $this->name;
    }

    public function equals(AggregateName $that): bool
    {
        return $this->name === $that->toString();
    }
}
