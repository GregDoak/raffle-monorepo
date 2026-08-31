<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Token\Model;

use App\Framework\Domain\Model\AggregateId;
use App\Framework\Domain\Model\AggregateName;

final readonly class TokenAggregateId extends AggregateId
{
    protected static function getAggregateName(): AggregateName
    {
        return TokenAggregateName::create();
    }
}
