<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Token\Exception\UsernamePassword;

use App\Framework\Domain\Exception\InvariantViolation;

use function sprintf;

final class InvalidUsername extends InvariantViolation
{
    public static function fromTooShort(string $className, int $minLength): self
    {
        return self::fromSubjectAndMessage(
            'username',
            sprintf('The "%s" must be at least %d characters.', $className, $minLength),
        );
    }

    public static function fromTooLong(string $className, int $maxLength): self
    {
        return self::fromSubjectAndMessage(
            'username',
            sprintf('The "%s" must not exceed %d characters.', $className, $maxLength),
        );
    }
}
