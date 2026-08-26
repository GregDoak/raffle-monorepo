<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\PersonalData\Exception;

use App\Framework\Domain\Exception\InvariantViolation;

use function sprintf;

final class InvalidEmailAddress extends InvariantViolation
{
    public static function fromInvalidFormat(string $value): self
    {
        return self::fromSubjectAndMessage(
            'emailAddress',
            sprintf('The email address "%s" is not a valid format.', $value),
        );
    }
}
