<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Application\Command\RecordSuccessfulLogin;

use App\Framework\Application\Command\AbstractCommand;
use App\RaffleDemo\Account\Domain\Account\Model\AccountAggregateId;
use App\RaffleDemo\Account\Domain\Token\ValueObject\Context;

final readonly class RecordSuccessfulLoginCommand extends AbstractCommand
{
    private function __construct(
        public AccountAggregateId $accountId,
        public Context $context,
        private string $correlationId,
        private string $causationId,
    ) {
        parent::__construct(
            $this->correlationId,
            $this->causationId,
        );
    }

    public static function fromUsernamePassword(
        string $accountId,
        string $correlationId,
    ): self {
        return new self(
            accountId: AccountAggregateId::fromString($accountId),
            context: Context::UsernamePassword,
            correlationId: $correlationId,
            causationId: $correlationId,
        );
    }

    public function serialize(): array
    {
        return [
            'accountId' => $this->accountId->toString(),
            'context' => $this->context->value,
        ];
    }
}
