<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Account\Repository;

use App\Framework\Domain\Exception\AggregateNotFound;
use App\Framework\Domain\Model\Event\AggregateEventsBus;
use App\Framework\Domain\Repository\EventStore;
use App\RaffleDemo\Account\Domain\Account\Model\Account;
use App\RaffleDemo\Account\Domain\Account\Model\AccountAggregateId;
use App\RaffleDemo\Account\Domain\Account\Model\AccountAggregateName;
use App\RaffleDemo\Account\Domain\PersonalData\Model\PersonalData;
use App\RaffleDemo\Account\Domain\PersonalData\Repository\PersonalDataRepository;

final readonly class AccountEventStoreRepository
{
    public function __construct(
        private EventStore $eventStore,
        private PersonalDataRepository $personalDataRepository,
        private AggregateEventsBus $aggregateEventsBus,
    ) {
    }

    public function store(Account $account): void
    {
        $events = $account->flushEvents();

        $this->eventStore->store($events);

        $this->aggregateEventsBus->publish($events);
    }

    public function get(AccountAggregateId $id): Account
    {
        $events = $this->eventStore->get(AccountAggregateName::create(), $id);

        if ($events->count() === 0) {
            throw AggregateNotFound::fromAggregateNameAndAggregateId(AccountAggregateName::create(), $id);
        }

        $account = Account::buildFrom($events);

        try {
            $personalData = $this->personalDataRepository->getById($account->personalDataPointer->id);
        } catch (AggregateNotFound) {
            $personalData = PersonalData::fromAnonymized(
                $account->personalDataPointer->id,
                $account->personalDataPointer->version,
                $id,
            );
        }

        $account->addPersonalData($personalData);

        return $account;
    }
}
