<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\PersonalData\Model;

use App\Framework\Domain\Model\AggregateName;

final readonly class PersonalDataAggregateName extends AggregateName
{
    private const string VALUE = 'PersonalData';

    public static function create(): static
    {
        return self::fromString(self::VALUE);
    }
}
