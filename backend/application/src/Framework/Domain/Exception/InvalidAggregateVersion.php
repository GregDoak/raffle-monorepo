<?php

declare(strict_types=1);

namespace App\Framework\Domain\Exception;

use RuntimeException;

use function sprintf;

final class InvalidAggregateVersion extends RuntimeException
{
    public static function fromInvalidVersion(int $version, string $className): self
    {
        return new self(
            sprintf('The aggregate version must be larger than 0, "%d" was given for "%s".', $version, $className),
        );
    }
}
