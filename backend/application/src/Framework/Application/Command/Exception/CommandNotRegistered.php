<?php

declare(strict_types=1);

namespace App\Framework\Application\Command\Exception;

use App\Framework\Application\Command\Command;
use RuntimeException;

use function sprintf;

final class CommandNotRegistered extends RuntimeException implements CommandException
{
    public function __construct(Command $command)
    {
        parent::__construct(sprintf('The command "%s" is not registered with a handler', $command::class));
    }
}
