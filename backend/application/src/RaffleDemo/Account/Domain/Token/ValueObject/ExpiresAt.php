<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Token\ValueObject;

use App\Framework\Domain\ValueObject\AbstractNullableTimestamp;

final readonly class ExpiresAt extends AbstractNullableTimestamp
{
}
