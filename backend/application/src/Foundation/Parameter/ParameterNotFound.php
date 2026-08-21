<?php

declare(strict_types=1);

namespace App\Foundation\Parameter;

use RuntimeException;

use function sprintf;

final class ParameterNotFound extends RuntimeException
{
    private function __construct(string $key)
    {
        parent::__construct(sprintf('Parameter "%s" was not found.', $key));
    }

    public static function fromKey(string $key): self
    {
        return new self($key);
    }
}
