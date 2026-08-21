<?php

declare(strict_types=1);

namespace App\Foundation\Parameter;

interface ParameterInterface
{
    public static function get(string $key): string;
}
