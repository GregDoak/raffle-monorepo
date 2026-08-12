<?php

declare(strict_types=1);

namespace App\Foundation\Clock;

interface ClockInterface
{
    public static function now(): Timestamp;
}
