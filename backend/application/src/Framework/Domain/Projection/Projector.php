<?php

declare(strict_types=1);

namespace App\Framework\Domain\Projection;

use App\Framework\Domain\Model\Event\AggregateEventsSubscriber;

interface Projector extends AggregateEventsSubscriber
{
    public function getName(): ProjectorName;

    public function getType(): ProjectorType;
}
