<?php

declare(strict_types=1);

namespace App\Framework\Application\Command\Exception;

use App\Framework\Domain\Exception\AggregateNotFound as DomainAggregateNotFound;
use RuntimeException;

final class AggregateNotFound extends RuntimeException implements CommandException
{
    private function __construct(DomainAggregateNotFound $exception)
    {
        parent::__construct($exception->getMessage(), previous: $exception);
    }

    public static function fromAggregateNotFound(DomainAggregateNotFound $exception): self
    {
        return new self($exception);
    }
}
