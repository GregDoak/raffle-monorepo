<?php

declare(strict_types=1);

namespace App\Framework\Application\Query\Exception;

use App\Framework\Domain\Exception\AggregateNotFound as DomainAggregateNotFound;
use App\Framework\Domain\Exception\InvariantViolation;
use Throwable;

final readonly class ExceptionTransformer
{
    public function transform(Throwable $exception): QueryException
    {
        return match (true) {
            $exception instanceof DomainAggregateNotFound => ResourceNotFound::fromAggregateNotFound($exception),
            $exception instanceof InvariantViolation => ValidationErrors::fromInvariantViolation($exception),
            default => ApplicationFailure::fromThrowable($exception),
        };
    }
}
