<?php

declare(strict_types=1);

namespace App\Framework\Application\Command\Exception;

use RuntimeException;

use function sprintf;

final class AggregateNotFound extends RuntimeException implements CommandException
{
    private function __construct(string $aggregateName, string $aggregateId)
    {
        parent::__construct(sprintf('The requested id "%s" was not found on aggregate "%s".', $aggregateId, $aggregateName));
    }

    public static function fromNameAndId(string $aggregateName, string $aggregateId): self
    {
        return new self($aggregateName, $aggregateId);
    }
}
