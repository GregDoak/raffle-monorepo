<?php

declare(strict_types=1);

namespace App\Framework\Domain\Exception;

use App\Framework\Domain\Model\AggregateId;
use App\Framework\Domain\Model\AggregateName;
use RuntimeException;

use function sprintf;

final class AggregateNotFound extends RuntimeException implements DomainException
{
    private function __construct(
        public AggregateName $aggregateName,
        public AggregateId $aggregateId,
    ) {
        parent::__construct(
            sprintf('The requested id "%s" was not found on aggregate "%s".', $aggregateId->toString(), $aggregateName->toString()),
        );
    }

    public static function fromAggregateNameAndAggregateId(AggregateName $aggregateName, AggregateId $aggregateId): self
    {
        return new self($aggregateName, $aggregateId);
    }
}
