<?php

declare(strict_types=1);

namespace App\Framework\Application\Query;

use App\Foundation\Clock\Timestamp;

abstract readonly class AbstractQuery implements Query
{
    private Timestamp $occurredAt;

    protected function __construct(
        private string $correlationId,
        private string $causationId,
        private string $dispatchedBy,
    ) {
        $this->occurredAt = Timestamp::now();
    }

    public function getOccurredAt(): Timestamp
    {
        return $this->occurredAt;
    }

    public function getCorrelationId(): string
    {
        return $this->correlationId;
    }

    public function getCausationId(): string
    {
        return $this->causationId;
    }

    public function getDispatchedBy(): string
    {
        return $this->dispatchedBy;
    }
}
