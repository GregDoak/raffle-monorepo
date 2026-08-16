<?php

declare(strict_types=1);

namespace App\Framework\Application\Command;

use App\Foundation\Clock\Timestamp;

abstract readonly class AbstractCommand implements Command
{
    private Timestamp $occurredAt;

    protected function __construct(
        private string $correlationId,
        private string $causationId,
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
}
