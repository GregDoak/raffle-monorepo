<?php

declare(strict_types=1);

namespace App\Framework\Application\Query\Exception;

use RuntimeException;

use function sprintf;

final class ResourceNotFound extends RuntimeException implements QueryException
{
    private function __construct(string $id)
    {
        parent::__construct(sprintf('The requested id "%s" was not found.', $id));
    }

    public static function fromId(string $id): self
    {
        return new self($id);
    }
}
