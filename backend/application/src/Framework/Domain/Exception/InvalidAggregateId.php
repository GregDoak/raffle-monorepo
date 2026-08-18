<?php

declare(strict_types=1);

namespace App\Framework\Domain\Exception;

final class InvalidAggregateId extends InvariantViolation
{
    public static function fromInvalidId(string $subject): self
    {
        return self::fromSubjectAndMessage($subject, 'The id is not a valid id.');
    }
}
