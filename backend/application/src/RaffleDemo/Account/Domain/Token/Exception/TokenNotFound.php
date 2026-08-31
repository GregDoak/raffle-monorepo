<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Token\Exception;

use App\Framework\Domain\Exception\DomainException;
use App\RaffleDemo\Account\Domain\Account\Model\AccountAggregateId;
use App\RaffleDemo\Account\Domain\Token\ValueObject\Context;
use RuntimeException;

use function sprintf;

final class TokenNotFound extends RuntimeException implements DomainException
{
    public static function fromAccountIdAndContext(AccountAggregateId $accountId, Context $context): self
    {
        return new self(sprintf(
            'No token found for account "%s" and context "%s".',
            $accountId->toString(),
            $context->value,
        ));
    }

    public static function fromContext(Context $context): self
    {
        return new self(sprintf('No token found for context "%s" matching the given selector.', $context->value));
    }
}
