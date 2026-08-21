<?php

declare(strict_types=1);

namespace App\Foundation\Parameter;

final class Parameter
{
    private static ParameterInterface $provider;

    public static function get(string $key): string
    {
        return self::provider()::get($key);
    }

    public static function set(ParameterInterface $provider): void
    {
        self::$provider = $provider;
    }

    private static function provider(): ParameterInterface
    {
        return self::$provider ??= new EnvParameter();
    }
}
