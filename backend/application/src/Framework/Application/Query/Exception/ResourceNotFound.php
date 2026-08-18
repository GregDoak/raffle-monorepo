<?php

declare(strict_types=1);

namespace App\Framework\Application\Query\Exception;

use App\Framework\Domain\Exception\AggregateNotFound;
use RuntimeException;

final class ResourceNotFound extends RuntimeException implements QueryException
{
    private function __construct(AggregateNotFound $exception)
    {
        parent::__construct($exception->getMessage(), previous: $exception);
    }

    public static function fromAggregateNotFound(AggregateNotFound $exception): self
    {
        return new self($exception);
    }
}
