<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Token\ValueObject\UsernamePassword;

use App\Framework\Domain\ValueObject\AbstractString;
use App\RaffleDemo\Account\Domain\Token\Exception\UsernamePassword\InvalidUsername;

final readonly class Username extends AbstractString
{
    private const int MIN_LENGTH = 3;
    private const int MAX_LENGTH = 100;

    protected function __construct(string $value)
    {
        if (mb_strlen($value) < self::MIN_LENGTH) {
            throw InvalidUsername::fromTooShort(self::class, self::MIN_LENGTH);
        }

        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw InvalidUsername::fromTooLong(self::class, self::MAX_LENGTH);
        }

        parent::__construct($value);
    }
}
