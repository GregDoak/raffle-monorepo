<?php

declare(strict_types=1);

namespace App\Framework\Domain\Exception;

use App\Framework\Domain\Model\AggregateId;
use RuntimeException;

final class AggregateNotFound extends RuntimeException
{
    private function __construct(
        public string $id,
    ) {
        parent::__construct('The requested id was not found.');
    }

    public static function fromAggregateId(AggregateId $id): self
    {
        return new self($id->toString());
    }
}
