<?php

declare(strict_types=1);

namespace App\Framework\Application\Command\Exception;

use App\Framework\Application\Command\Exception\AggregateNotFound as ApplicationAggregateNotFound;
use App\Framework\Domain\Exception\AggregateNotFound as DomainAggregateNotFound;
use App\Framework\Domain\Exception\InvariantViolation;
use Throwable;

final readonly class ExceptionTransformer
{
    public function transform(Throwable $exception): CommandException
    {
        return match (true) {
            $exception instanceof DomainAggregateNotFound => ApplicationAggregateNotFound::fromAggregateNotFound($exception),
            $exception instanceof InvariantViolation => ValidationErrors::fromInvariantViolation($exception),
            default => ApplicationFailure::fromThrowable($exception),
        };
    }
}
