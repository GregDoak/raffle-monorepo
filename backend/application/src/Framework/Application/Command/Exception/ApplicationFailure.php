<?php

declare(strict_types=1);

namespace App\Framework\Application\Command\Exception;

use RuntimeException;
use Throwable;

final class ApplicationFailure extends RuntimeException implements CommandException
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
