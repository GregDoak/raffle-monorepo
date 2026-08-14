<?php

declare(strict_types=1);

namespace App\Framework\Domain\Model\Event;

use App\Foundation\Clock\Timestamp;
use App\Framework\Domain\Model\AggregateId;
use App\Framework\Domain\Model\AggregateName;
use App\Framework\Domain\Model\AggregateVersion;

interface AggregateEvent
{
    public function getEventName(): string;

    public function getAggregateName(): AggregateName;

    public function getAggregateId(): AggregateId;

    public function getAggregateVersion(): AggregateVersion;

    public function getOccurredAt(): Timestamp;

    public function getCorrelationId(): string;

    public function getCausationId(): string;

    public function serialize(): string;

    public static function deserialize(string $serialized): self;
}
