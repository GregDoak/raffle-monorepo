<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Account\Exception;

use App\Framework\Domain\Exception\DomainException;
use App\RaffleDemo\Account\Domain\Account\ValueObject\PersonalDataPointer;
use RuntimeException;

use function sprintf;

final class InvalidPersonalDataPointer extends RuntimeException implements DomainException
{
    public static function fromMismatchedPointer(
        PersonalDataPointer $expected,
        PersonalDataPointer $actual,
    ): self {
        return new self(
            sprintf(
                "The personal data does not match the account's pointer: expected id %s version %d, got id %s version %d.",
                $expected->id->toString(),
                $expected->version->toInt(),
                $actual->id->toString(),
                $actual->version->toInt(),
            ),
        );
    }
}
