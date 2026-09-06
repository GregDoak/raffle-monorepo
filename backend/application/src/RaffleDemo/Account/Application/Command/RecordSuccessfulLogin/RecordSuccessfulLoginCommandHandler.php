<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Application\Command\RecordSuccessfulLogin;

use App\Framework\Application\Command\CommandHandler;
use App\Framework\Domain\Repository\TransactionBoundary;
use App\RaffleDemo\Account\Domain\Account\Repository\AccountEventStoreRepository;
use App\RaffleDemo\Account\Domain\Account\ValueObject\LoginResult;
use Throwable;

final readonly class RecordSuccessfulLoginCommandHandler implements CommandHandler
{
    public function __construct(
        private TransactionBoundary $transactionBoundary,
        private AccountEventStoreRepository $eventStore,
    ) {
    }

    public function __invoke(RecordSuccessfulLoginCommand $command): void
    {
        $account = $this->eventStore->get($command->accountId);

        $account->recordLoginResult(
            loginResult: LoginResult::fromSuccessful(
                context: $command->context,
                occurredAt: $command->getOccurredAt(),
            ),
            correlationId: $command->getCorrelationId(),
            causationId: $command->getCommandId(),
        );

        $this->transactionBoundary->begin();

        try {
            $this->eventStore->store($account);
        } catch (Throwable $throwable) {
            $this->transactionBoundary->rollback();

            throw $throwable;
        }

        $this->transactionBoundary->commit();
    }
}
