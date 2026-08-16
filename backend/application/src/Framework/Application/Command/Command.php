<?php

declare(strict_types=1);

namespace App\Framework\Application\Command;

use App\Foundation\Clock\Timestamp;

interface Command
{
    public function getOccurredAt(): Timestamp;

    public function getCorrelationId(): string;

    public function getCausationId(): string;

    /** @return mixed[] */
    public function serialize(): array;
}
