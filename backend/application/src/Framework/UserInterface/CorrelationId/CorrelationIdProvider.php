<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\CorrelationId;

interface CorrelationIdProvider
{
    public function provide(): string;
}
