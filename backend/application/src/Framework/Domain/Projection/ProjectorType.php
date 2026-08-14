<?php

declare(strict_types=1);

namespace App\Framework\Domain\Projection;

enum ProjectorType
{
    case Async;
    case Sync;
}
