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
        string $correlationId,
        string $causationId,
        string $dispatchedBy,
    ) {
        parent::__construct($correlationId, $causationId, $dispatchedBy);
    }

    public static function fromUsernamePassword(
        string $accountId,
        string $correlationId,
        string $dispatchedBy,
        ?string $causationId = null,
    ): self {
        return new self(
            accountId: AccountAggregateId::fromString($accountId),
            context: Context::UsernamePassword,
            correlationId: $correlationId,
            causationId: $causationId ?? $correlationId,
            dispatchedBy: $dispatchedBy,
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
