<?php

declare(strict_types=1);

namespace App\Framework\Domain\Model;

final readonly class EventStreamPointer
{
    private function __construct(
        public int $position,
    ) {
    }

    public static function fromInt(int $position): self
    {
        return new self($position);
    }

    public static function fromNew(): self
    {
        return new self(0);
    }

    public function equals(self $that): bool
    {
        return $this->position === $that->position;
    }
}
