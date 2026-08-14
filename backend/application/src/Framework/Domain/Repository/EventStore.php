<?php

declare(strict_types=1);

namespace App\Framework\Domain\Repository;

use App\Framework\Domain\Model\AggregateEvents;
use App\Framework\Domain\Model\AggregateEventsStream;
use App\Framework\Domain\Model\AggregateId;
use App\Framework\Domain\Model\AggregateName;
use App\Framework\Domain\Model\EventStreamPointer;

interface EventStore
{
    public function get(AggregateName $name, AggregateId $id): AggregateEvents;

    public function store(AggregateEvents $events): void;

    public function stream(EventStreamPointer $start, int $limit): AggregateEventsStream;
}
