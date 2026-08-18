<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\Exception;

use RuntimeException;

final class ValidationErrors extends RuntimeException implements UserInterfaceException
{
    /** @param array<string, string[]> $errors */
    private function __construct(
        public readonly array $errors,
    ) {
        parent::__construct('Validation failed');
    }

    /** @param array<string, string[]> $errors */
    public static function fromErrors(array $errors): self
    {
        return new self($errors);
    }
}
