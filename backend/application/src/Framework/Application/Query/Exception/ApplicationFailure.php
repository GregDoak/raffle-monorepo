<?php

declare(strict_types=1);

namespace App\Framework\Application\Query\Exception;

use RuntimeException;
use Throwable;

final class ApplicationFailure extends RuntimeException implements QueryException
{
    private function __construct(Throwable $previous)
    {
        parent::__construct('An unexpected error has occurred.', previous: $previous);
    }

    public static function fromThrowable(Throwable $previous): self
    {
        return new self($previous);
    }
}
