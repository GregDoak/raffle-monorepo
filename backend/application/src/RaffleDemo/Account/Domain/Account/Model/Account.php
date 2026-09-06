<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Account\Model;

use App\Foundation\Clock\Timestamp;
use App\Foundation\Uuid\Uuid;
use App\Framework\Domain\Exception\AggregateEventNotHandled;
use App\Framework\Domain\Model\Aggregate;
use App\Framework\Domain\Model\AggregateEvents;
use App\Framework\Domain\Model\Event\AggregateEvent;
use App\RaffleDemo\Account\Domain\Account\Exception\InvalidPersonalDataPointer;
use App\RaffleDemo\Account\Domain\Account\Model\Event\AccountCreatedV1;
use App\RaffleDemo\Account\Domain\Account\Model\Event\AccountLoginSucceededV1;
use App\RaffleDemo\Account\Domain\Account\ValueObject\AccountRoleCollection;
use App\RaffleDemo\Account\Domain\Account\ValueObject\AccountStatus;
use App\RaffleDemo\Account\Domain\Account\ValueObject\LoginResult;
use App\RaffleDemo\Account\Domain\Account\ValueObject\LoginResultType;
use App\RaffleDemo\Account\Domain\Account\ValueObject\PersonalDataPointer;
use App\RaffleDemo\Account\Domain\Account\ValueObject\SuccessfulLoginCount;
use App\RaffleDemo\Account\Domain\PersonalData\Model\PersonalData;

final class Account extends Aggregate
{
    private AccountAggregateId $id;
    public private(set) PersonalDataPointer $personalDataPointer;
    public private(set) AccountRoleCollection $roles;
    public private(set) AccountStatus $status;
    public private(set) SuccessfulLoginCount $successfulLoginCount;
    public private(set) ?PersonalData $personalData = null;

    public function __construct()
    {
        $this->events = AggregateEvents::fromNew();
        $this->version = AccountAggregateVersion::fromNew();
    }

    public function getAggregateName(): AccountAggregateName
    {
        return AccountAggregateName::create();
    }

    public function getAggregateId(): AccountAggregateId
    {
        return $this->id;
    }

    public function getAggregateVersion(): AccountAggregateVersion
    {
        return $this->version; // @phpstan-ignore-line return.type
    }

    public function addPersonalData(PersonalData $personalData): void
    {
        $pointer = new PersonalDataPointer($personalData->id, $personalData->version);

        if ($pointer->equals($this->personalDataPointer) === false) {
            throw InvalidPersonalDataPointer::fromMismatchedPointer($this->personalDataPointer, $pointer);
        }

        $this->personalData = $personalData;
    }

    public static function create(
        AccountAggregateId $id,
        PersonalDataPointer $personalDataPointer,
        AccountRoleCollection $roles,
        string $correlationId,
        string $causationId,
        Timestamp $occurredAt,
    ): self {
        $account = new self();

        $account->raise(new AccountCreatedV1(
            eventId: Uuid::v7(),
            aggregateVersion: $account->getAggregateVersion(),
            aggregateId: $id,
            personalDataPointer: $personalDataPointer,
            roles: $roles,
            occurredAt: $occurredAt,
            correlationId: $correlationId,
            causationId: $causationId,
        ));

        return $account;
    }

    public function recordLoginResult(
        LoginResult $loginResult,
        string $correlationId,
        string $causationId,
    ): void {
        $this->raise(match ($loginResult->type) {
            LoginResultType::Succeeded => new AccountLoginSucceededV1(
                eventId: Uuid::v7(),
                aggregateVersion: $this->getAggregateVersion(),
                aggregateId: $this->id,
                context: $loginResult->context,
                occurredAt: $loginResult->occurredAt,
                correlationId: $correlationId,
                causationId: $causationId,
            ),
        });
    }

    public function apply(AggregateEvent $event): void
    {
        match ($event::class) {
            AccountCreatedV1::class => $this->applyAccountCreated($event),
            AccountLoginSucceededV1::class => $this->applyLoginSucceeded($event),
            default => throw AggregateEventNotHandled::notHandledByAggregate($event::class, self::class),
        };
    }

    private function applyAccountCreated(AccountCreatedV1 $event): void
    {
        $this->id = $event->aggregateId;
        $this->personalDataPointer = $event->personalDataPointer;
        $this->roles = $event->roles;
        $this->status = AccountStatus::Created;
        $this->successfulLoginCount = SuccessfulLoginCount::zero();
    }

    private function applyLoginSucceeded(AccountLoginSucceededV1 $event): void
    {
        $this->successfulLoginCount = $this->successfulLoginCount->increment();
    }
}
