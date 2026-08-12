<?php

declare(strict_types=1);

namespace App\Foundation\Clock;

final readonly class NativeClock implements ClockInterface
{
    public static function now(): Timestamp
    {
        return Timestamp::now();
    }
}
