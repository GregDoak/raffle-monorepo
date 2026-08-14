<?php

declare(strict_types=1);

namespace App\Framework\Domain\Model\Event;

use App\Framework\Domain\Model\AggregateEvents;

interface AggregateEventsBus
{
    public function publish(AggregateEvents $events): void;
}
