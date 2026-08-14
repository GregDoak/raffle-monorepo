<?php

declare(strict_types=1);

namespace App\Framework\Domain\Model;

use App\Framework\Domain\Model\Event\AggregateEvent;

abstract class Aggregate
{
    protected AggregateEvents $events;
    protected AggregateVersion $version;

    abstract public function __construct();

    abstract public function getAggregateName(): AggregateName;

    abstract public function getAggregateId(): AggregateId;

    abstract public function getAggregateVersion(): AggregateVersion;

    public function countOfEvents(): int
    {
        return $this->events->count();
    }

    public function flushEvents(): AggregateEvents
    {
        $events = $this->events;

        $this->events = AggregateEvents::fromNew();

        return $events;
    }

    public static function buildFrom(AggregateEvents $events): static
    {
        $aggregate = new static();

        foreach ($events as $event) {
            $aggregate->apply($event);

            $aggregate->version = $aggregate->version->next();
        }

        return $aggregate;
    }

    protected function raise(AggregateEvent $event): void
    {
        $this->apply($event);

        $this->version = $this->version->next();

        $this->events = $this->events->add($event);
    }

    abstract public function apply(AggregateEvent $event): void;
}
