<?php

declare(strict_types=1);

namespace App\Framework\Application\Command;

interface CommandBus
{
    public function dispatchSync(Command $command): void;
}
