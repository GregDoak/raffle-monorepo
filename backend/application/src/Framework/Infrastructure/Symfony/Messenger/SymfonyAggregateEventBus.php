<?php

declare(strict_types=1);

namespace App\Framework\Infrastructure\Symfony\Messenger;

use App\Framework\Domain\Model\AggregateEvents;
use App\Framework\Domain\Model\Event\AggregateEventsBus;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class SymfonyAggregateEventBus implements AggregateEventsBus
{
    public function __construct(
        private MessageBusInterface $aggregateEventBus,
    ) {
    }

    public function publish(AggregateEvents $events): void
    {
        $this->aggregateEventBus->dispatch($events);
    }
}
