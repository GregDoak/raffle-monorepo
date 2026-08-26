<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\PersonalData\ValueObject;

use App\Framework\Domain\ValueObject\AbstractString;
use App\RaffleDemo\Account\Domain\PersonalData\Exception\InvalidFirstName;

final readonly class FirstName extends AbstractString
{
    private const int MAX_LENGTH = 100;

    protected function __construct(string $value)
    {
        if (trim($value) === '') {
            throw InvalidFirstName::fromEmptyValue(self::class);
        }

        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw InvalidFirstName::fromTooLong(self::class, self::MAX_LENGTH);
        }

        parent::__construct($value);
    }

    public static function fromAnonymized(): self
    {
        return self::fromString('Anonymized');
    }
}
