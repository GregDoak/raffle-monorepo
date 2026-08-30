<?php

declare(strict_types=1);

namespace App\Framework\Infrastructure\Symfony\Messenger;

use App\Framework\Application\Command\Command;
use App\Framework\Application\Command\CommandBus;
use App\Framework\Application\Command\Exception\ExceptionTransformer;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;
use Symfony\Component\Messenger\Stamp\TransportNamesStamp;
use Throwable;

final readonly class SymfonyCommandBus implements CommandBus
{
    public function __construct(
        private MessageBusInterface $commandBus,
        private ExceptionTransformer $exceptionTransformer,
    ) {
    }

    public function dispatchSync(Command $command): void
    {
        $this->dispatch($command, new TransportNamesStamp(['sync']));
    }

    private function dispatch(Command $command, StampInterface $stamp): void
    {
        try {
            $this->commandBus->dispatch($command, [$stamp]);
        } catch (Throwable $exception) {
            throw $this->exceptionTransformer->transform($exception);
        }
    }
}
