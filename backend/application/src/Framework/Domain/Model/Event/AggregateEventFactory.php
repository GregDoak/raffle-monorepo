<?php

declare(strict_types=1);

namespace App\Framework\Domain\Model\Event;

use App\Framework\Domain\Exception\AggregateEventNotHandled;

interface AggregateEventFactory
{
    /** @throws AggregateEventNotHandled */
    public function fromSerialized(string $eventName, string $eventPayload): AggregateEvent;
}
