<?php

declare(strict_types=1);

namespace App\Framework\Infrastructure\Symfony\Messenger;

use App\Framework\Application\Query\Exception\ExceptionTransformer;
use App\Framework\Application\Query\Query;
use App\Framework\Application\Query\QueryBus;
use App\Framework\Application\Query\Result;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class SymfonyQueryBus implements QueryBus
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $queryBus,
        private readonly ExceptionTransformer $exceptionTransformer,
    ) {
        $this->messageBus = $queryBus;
    }

    public function query(Query $query): Result
    {
        try {
            return $this->handle($query); // @phpstan-ignore return.type
        } catch (Throwable $exception) {
            throw $this->exceptionTransformer->transform($exception);
        }
    }
}
