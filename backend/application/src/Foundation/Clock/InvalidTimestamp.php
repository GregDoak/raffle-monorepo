<?php

declare(strict_types=1);

namespace App\Foundation\Clock;

use RuntimeException;

use function sprintf;

final class InvalidTimestamp extends RuntimeException
{
    private function __construct(
        public string $template,
    ) {
        parent::__construct(sprintf($this->template, 'timestamp'));
    }

    public static function fromEmpty(): self
    {
        return new self('The %s value cannot be empty.');
    }

    public static function fromInvalid(): self
    {
        return new self('The %s value cannot be in an invalid format.');
    }
}
