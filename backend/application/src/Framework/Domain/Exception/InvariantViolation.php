<?php

declare(strict_types=1);

namespace App\Framework\Domain\Exception;

use RuntimeException;

abstract class InvariantViolation extends RuntimeException implements DomainException
{
    final private function __construct(
        public readonly string $subject,
        string $message,
    ) {
        parent::__construct($message);
    }

    public static function fromSubjectAndMessage(string $subject, string $message): static
    {
        return new static($subject, $message);
    }
}
