<?php

declare(strict_types=1);

namespace App\Framework\Application\Command;

use App\Foundation\Clock\Timestamp;
use App\Foundation\Uuid\Uuid;

abstract readonly class AbstractCommand implements Command
{
    private string $commandId;
    private Timestamp $occurredAt;

    protected function __construct(
        private string $correlationId,
        private string $causationId,
    ) {
        $this->commandId = Uuid::v7();
        $this->occurredAt = Timestamp::now();
    }

    public function getCommandId(): string
    {
        return $this->commandId;
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
