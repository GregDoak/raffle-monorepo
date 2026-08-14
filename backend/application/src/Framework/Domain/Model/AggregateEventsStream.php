<?php

declare(strict_types=1);

namespace App\Framework\Domain\Model;

final readonly class AggregateEventsStream
{
    public function __construct(
        private EventStreamPointer $next,
        private AggregateEvents $events,
    ) {
    }

    public function getNextPointer(): EventStreamPointer
    {
        return $this->next;
    }

    public function getAggregateEvents(): AggregateEvents
    {
        return $this->events;
    }
}
