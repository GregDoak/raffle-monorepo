<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Token\Model;

use App\Framework\Domain\Model\AggregateName;

final readonly class TokenAggregateName extends AggregateName
{
    private const string VALUE = 'Token';

    public static function create(): static
    {
        return self::fromString(self::VALUE);
    }
}
