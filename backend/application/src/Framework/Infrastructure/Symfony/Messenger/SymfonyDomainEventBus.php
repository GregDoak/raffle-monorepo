<?php

declare(strict_types=1);

namespace App\Framework\Infrastructure\Symfony\Messenger;

use App\Foundation\DomainEventRegistry\DomainEvent;
use App\Framework\Domain\Event\DomainEventBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\TransportMessageIdStamp;

final readonly class SymfonyDomainEventBus implements DomainEventBus
{
    public function __construct(
        private MessageBusInterface $domainEventBus,
    ) {
    }

    public function publish(DomainEvent $event): void
    {
        $this->domainEventBus->dispatch($event, [new TransportMessageIdStamp($event->getEventId())]);
    }
}
