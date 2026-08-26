<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Account\Model;

use App\Framework\Domain\Model\AggregateName;

final readonly class AccountAggregateName extends AggregateName
{
    private const string VALUE = 'Account';

    public static function create(): static
    {
        return self::fromString(self::VALUE);
    }
}
