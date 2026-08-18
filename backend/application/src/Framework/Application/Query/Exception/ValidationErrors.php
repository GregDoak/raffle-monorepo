<?php

declare(strict_types=1);

namespace App\Framework\Application\Query\Exception;

use App\Framework\Domain\Exception\InvariantViolation;
use RuntimeException;
use Throwable;

final class ValidationErrors extends RuntimeException implements QueryException
{
    /** @param array<string, string[]> $errors */
    private function __construct(
        public readonly array $errors,
        Throwable $previous,
    ) {
        parent::__construct('Validation failed', previous: $previous);
    }

    public static function fromInvariantViolation(InvariantViolation $exception): self
    {
        return new self(errors: [$exception->subject => [$exception->getMessage()]], previous: $exception);
    }
}
