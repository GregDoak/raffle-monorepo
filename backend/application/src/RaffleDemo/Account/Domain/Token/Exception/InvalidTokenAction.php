<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Token\Exception;

use App\Framework\Domain\Exception\InvariantViolation;
use App\RaffleDemo\Account\Domain\Token\ValueObject\Context;

use function sprintf;

final class InvalidTokenAction extends InvariantViolation
{
    public static function cannotChangePasswordOnContext(Context $actual): self
    {
        return self::fromSubjectAndMessage(
            'token',
            sprintf('Cannot change password on context "%s"; only "%s" supports password changes.', $actual->value, Context::UsernamePassword->value),
        );
    }
}
