<?php

declare(strict_types=1);

namespace App\Foundation\Serializer;

use function json_decode;
use function json_encode;

final readonly class JsonSerializer
{
    public static function deserialize(string $json): mixed
    {
        return json_decode($json, associative: true, flags: JSON_THROW_ON_ERROR);
    }

    public static function serialize(mixed $value): string
    {
        return json_encode($value, JSON_THROW_ON_ERROR);
    }
}
