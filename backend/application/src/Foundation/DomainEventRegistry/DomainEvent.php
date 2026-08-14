<?php

declare(strict_types=1);

namespace App\Foundation\DomainEventRegistry;

use DateTimeImmutable;

interface DomainEvent
{
    public function getEventId(): string;

    public function getEventType(): string;

    public function getAggregateId(): string;

    public function getOccurredAt(): DateTimeImmutable;

    public function getCorrelationId(): string;

    public function getCausationId(): string;

    /** @return mixed[] */
    public function serialize(): array;
}
