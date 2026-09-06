<?php

declare(strict_types=1);

namespace App\Framework\Application\Command;

use App\Foundation\Clock\Timestamp;

interface Command
{
    public function getCommandId(): string;

    public function getOccurredAt(): Timestamp;

    public function getCorrelationId(): string;

    public function getCausationId(): string;

    public function getDispatchedBy(): string;

    /** @return mixed[] */
    public function serialize(): array;
}
