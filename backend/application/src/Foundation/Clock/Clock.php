<?php

declare(strict_types=1);

namespace App\Foundation\Clock;

final class Clock
{
    private static ClockInterface $clock;

    public static function now(): Timestamp
    {
        return self::get()::now();
    }

    public static function set(ClockInterface $clock): void
    {
        self::$clock = $clock;
    }

    private static function get(): ClockInterface
    {
        return self::$clock ??= new NativeClock();
    }
}
