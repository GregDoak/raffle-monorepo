<?php

declare(strict_types=1);

namespace App\Foundation\Parameter;

final readonly class EnvParameter implements ParameterInterface
{
    public static function get(string $key): string
    {
        $value = getenv($key);

        if ($value === false) {
            throw ParameterNotFound::fromKey($key);
        }

        return $value;
    }
}
