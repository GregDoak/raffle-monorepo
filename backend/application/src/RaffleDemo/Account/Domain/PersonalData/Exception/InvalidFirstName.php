<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\PersonalData\Exception;

use App\Framework\Domain\Exception\InvariantViolation;

use function sprintf;

final class InvalidFirstName extends InvariantViolation
{
    public static function fromEmptyValue(string $className): self
    {
        return self::fromSubjectAndMessage(
            'firstName',
            sprintf('The "%s" is required and cannot be empty.', $className),
        );
    }

    public static function fromTooLong(string $className, int $maxLength): self
    {
        return self::fromSubjectAndMessage(
            'firstName',
            sprintf('The "%s" must not exceed %d characters.', $className, $maxLength),
        );
    }
}
