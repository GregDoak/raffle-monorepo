<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Token\Exception;

use App\Framework\Domain\Exception\InvariantViolation;
use App\RaffleDemo\Account\Domain\Account\Model\AccountAggregateId;
use App\RaffleDemo\Account\Domain\Token\ValueObject\Context;

use function sprintf;

final class DuplicateSelector extends InvariantViolation
{
    public static function fromContext(Context $context): self
    {
        $subject = self::subjectFor($context);

        return self::fromSubjectAndMessage(
            $subject,
            sprintf('The "%s" is already in use.', $subject),
        );
    }

    public static function fromContextAndAccountId(Context $context, AccountAggregateId $accountId): self
    {
        $subject = self::subjectFor($context);

        return self::fromSubjectAndMessage(
            $subject,
            sprintf('The "%s" is already in use for account "%s".', $subject, $accountId->toString()),
        );
    }

    private static function subjectFor(Context $context): string
    {
        return match ($context) {
            Context::UsernamePassword => 'emailAddress',
            Context::RefreshToken => 'refreshToken',
        };
    }
}
