<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\PersonalData\ValueObject;

use App\Framework\Domain\ValueObject\AbstractString;
use App\RaffleDemo\Account\Domain\PersonalData\Exception\InvalidEmailAddress;

use function filter_var;

use const FILTER_VALIDATE_EMAIL;

final readonly class EmailAddress extends AbstractString
{
    protected function __construct(string $value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw InvalidEmailAddress::fromInvalidFormat($value);
        }

        parent::__construct($value);
    }

    public static function fromAnonymized(): self
    {
        return self::fromString('anonymized@anonymized.invalid');
    }
}
