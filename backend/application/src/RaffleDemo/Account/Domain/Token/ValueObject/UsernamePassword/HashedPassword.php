<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Token\ValueObject\UsernamePassword;

use App\Framework\Domain\ValueObject\AbstractString;
use App\RaffleDemo\Account\Domain\Token\Exception\UsernamePassword\InvalidHashedPassword;

final readonly class HashedPassword extends AbstractString
{
    private const int MIN_LENGTH = 60;

    protected function __construct(string $value)
    {
        if (mb_strlen($value) < self::MIN_LENGTH) {
            throw InvalidHashedPassword::fromTooShort(self::class, self::MIN_LENGTH);
        }

        parent::__construct($value);
    }
}
