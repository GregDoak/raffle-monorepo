<?php

declare(strict_types=1);

namespace App\Framework\Domain\Repository;

use App\Framework\Domain\Model\EventStreamPointer;
use App\Framework\Domain\Projection\ProjectorName;

interface EventStreamPointerStore
{
    public function get(ProjectorName $projectorName): EventStreamPointer;

    public function store(ProjectorName $projectorName, EventStreamPointer $pointer): void;
}
