<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Account\Model\Event;

use App\Framework\Domain\Exception\AggregateEventNotHandled;
use App\Framework\Domain\Model\Event\AggregateEvent;
use App\Framework\Domain\Model\Event\AggregateEventFactory;

final readonly class AccountEventFactory implements AggregateEventFactory
{
    public function fromSerialized(string $eventName, string $eventPayload): AggregateEvent
    {
        return match ($eventName) {
            AccountCreatedV1::EVENT_NAME => AccountCreatedV1::deserialize($eventPayload),
            AccountLoginSucceededV1::EVENT_NAME => AccountLoginSucceededV1::deserialize($eventPayload),
            default => throw throw AggregateEventNotHandled::notHandledByEventFactory($eventName, self::class),
        };
    }
}
