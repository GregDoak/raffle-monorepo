<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Token\Exception\UsernamePassword;

use App\Framework\Domain\Exception\InvariantViolation;

use function sprintf;

final class InvalidHashedPassword extends InvariantViolation
{
    public static function fromTooShort(string $className, int $minLength): self
    {
        return self::fromSubjectAndMessage(
            'hashedPassword',
            sprintf('The "%s" must be at least %d characters.', $className, $minLength),
        );
    }
}
