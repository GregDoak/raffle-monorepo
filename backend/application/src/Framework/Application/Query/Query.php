<?php

declare(strict_types=1);

namespace App\Framework\Application\Query;

use App\Foundation\Clock\Timestamp;

interface Query
{
    public function getOccurredAt(): Timestamp;

    public function getCorrelationId(): string;

    public function getCausationId(): string;

    /** @return mixed[] */
    public function serialize(): array;
}
