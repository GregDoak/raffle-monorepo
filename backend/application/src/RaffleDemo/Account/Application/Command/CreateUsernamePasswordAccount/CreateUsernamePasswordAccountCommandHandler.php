<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Application\Command\CreateUsernamePasswordAccount;

use App\Framework\Application\Command\CommandHandler;
use App\Framework\Domain\Repository\TransactionBoundary;
use App\RaffleDemo\Account\Domain\Account\Model\Account;
use App\RaffleDemo\Account\Domain\Account\Repository\AccountEventStoreRepository;
use App\RaffleDemo\Account\Domain\Account\ValueObject\AccountRole;
use App\RaffleDemo\Account\Domain\Account\ValueObject\AccountRoleCollection;
use App\RaffleDemo\Account\Domain\Account\ValueObject\PersonalDataPointer;
use App\RaffleDemo\Account\Domain\PersonalData\Model\PersonalData;
use App\RaffleDemo\Account\Domain\PersonalData\Repository\PersonalDataRepository;
use Throwable;

final readonly class CreateUsernamePasswordAccountCommandHandler implements CommandHandler
{
    public function __construct(
        private TransactionBoundary $transactionBoundary,
        private AccountEventStoreRepository $eventStore,
        private PersonalDataRepository $personalDataRepository,
    ) {
    }

    public function __invoke(CreateUsernamePasswordAccountCommand $command): void
    {
        $personalData = PersonalData::fromNew(
            accountId: $command->id,
            firstName: $command->firstName,
            lastName: $command->lastName,
            emailAddress: $command->emailAddress,
        );

        $account = Account::create(
            id: $command->id,
            personalDataPointer: new PersonalDataPointer(
                id: $personalData->id,
                version: $personalData->version,
            ),
            roles: AccountRoleCollection::fromRoles(AccountRole::AccountUser),
            correlationId: $command->getCorrelationId(),
            causationId: $command->getCommandId(),
            occurredAt: $command->getOccurredAt(),
        );

        $account->addPersonalData($personalData);

        $this->transactionBoundary->begin();

        try {
            $this->personalDataRepository->store($personalData);
            $this->eventStore->store($account);
        } catch (Throwable $throwable) {
            $this->transactionBoundary->rollback();

            throw $throwable;
        }

        $this->transactionBoundary->commit();
    }
}
