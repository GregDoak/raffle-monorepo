<?php

declare(strict_types=1);

namespace App\Foundation\Clock;

final class FrozenClock implements ClockInterface
{
    private static Timestamp $now;

    public function __construct(string $now = 'now')
    {
        self::$now = Timestamp::fromString($now);
    }

    public static function now(): Timestamp
    {
        return self::$now;
    }
}
