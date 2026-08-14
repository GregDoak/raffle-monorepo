<?php

declare(strict_types=1);

namespace App\Framework\Domain\Event;

use App\Foundation\DomainEventRegistry\DomainEvent;

interface DomainEventBus
{
    public function publish(DomainEvent $event): void;
}
