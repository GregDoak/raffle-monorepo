<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Account\Model\Event;

use App\Foundation\Clock\Timestamp;
use App\Foundation\Serializer\JsonSerializer;
use App\Framework\Domain\Model\AggregateId;
use App\Framework\Domain\Model\AggregateName;
use App\Framework\Domain\Model\AggregateVersion;
use App\Framework\Domain\Model\Event\AggregateEvent;
use App\RaffleDemo\Account\Domain\Account\Model\AccountAggregateId;
use App\RaffleDemo\Account\Domain\Account\Model\AccountAggregateName;
use App\RaffleDemo\Account\Domain\Account\Model\AccountAggregateVersion;
use App\RaffleDemo\Account\Domain\Account\ValueObject\AccountRoleCollection;
use App\RaffleDemo\Account\Domain\Account\ValueObject\PersonalDataPointer;

final readonly class AccountCreatedV1 implements AggregateEvent
{
    public const string EVENT_NAME = 'account.created.v1';

    public function __construct(
        public string $eventId,
        public AccountAggregateVersion $aggregateVersion,
        public AccountAggregateId $aggregateId,
        public PersonalDataPointer $personalDataPointer,
        public AccountRoleCollection $roles,
        public Timestamp $occurredAt,
        public string $correlationId,
        public string $causationId,
    ) {
    }

    public function getEventId(): string
    {
        return $this->eventId;
    }

    public function getEventName(): string
    {
        return self::EVENT_NAME;
    }

    public function getAggregateName(): AggregateName
    {
        return AccountAggregateName::create();
    }

    public function getAggregateId(): AggregateId
    {
        return $this->aggregateId;
    }

    public function getAggregateVersion(): AggregateVersion
    {
        return $this->aggregateVersion;
    }

    public function getOccurredAt(): Timestamp
    {
        return $this->occurredAt;
    }

    public function getCorrelationId(): string
    {
        return $this->correlationId;
    }

    public function getCausationId(): string
    {
        return $this->causationId;
    }

    public function serialize(): string
    {
        return JsonSerializer::serialize([
            'event_id' => $this->eventId,
            'aggregate_version' => $this->aggregateVersion->toInt(),
            'aggregate_id' => $this->aggregateId->toString(),
            'personal_data_pointer' => $this->personalDataPointer->serialize(),
            'roles' => $this->roles->serialize(),
            'occurred_at' => $this->occurredAt->toString(),
            'correlation_id' => $this->correlationId,
            'causation_id' => $this->causationId,
        ]);
    }

    public static function deserialize(string $serialized): AggregateEvent
    {
        /**
         * @var array{
         *     event_id: string,
         *     aggregate_version: int,
         *     aggregate_id: string,
         *     personal_data_pointer: array{id: string, version: int},
         *     roles: string[],
         *     occurred_at: string,
         *     correlation_id: string,
         *     causation_id: string,
         * } $data
         */
        $data = JsonSerializer::deserialize($serialized);

        return new self(
            eventId: $data['event_id'],
            aggregateVersion: AccountAggregateVersion::fromInt($data['aggregate_version']),
            aggregateId: AccountAggregateId::fromString($data['aggregate_id']),
            personalDataPointer: PersonalDataPointer::deserialize($data['personal_data_pointer']),
            roles: AccountRoleCollection::deserialize($data['roles']),
            occurredAt: Timestamp::fromString($data['occurred_at']),
            correlationId: $data['correlation_id'],
            causationId: $data['causation_id'],
        );
    }
}
