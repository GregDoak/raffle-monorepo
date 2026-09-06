<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Account\ValueObject;

use App\Framework\Domain\ValueObject\AbstractInt;

final readonly class SuccessfulLoginCount extends AbstractInt
{
    public static function zero(): self
    {
        return self::fromInt(0);
    }

    public function increment(): self
    {
        return self::fromInt($this->toInt() + 1);
    }
}
