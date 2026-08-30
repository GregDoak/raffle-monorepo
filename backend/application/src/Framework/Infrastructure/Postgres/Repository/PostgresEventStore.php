<?php

declare(strict_types=1);

namespace App\Framework\Infrastructure\Postgres\Repository;

use App\Framework\Domain\Model\AggregateEvents;
use App\Framework\Domain\Model\AggregateEventsStream;
use App\Framework\Domain\Model\AggregateId;
use App\Framework\Domain\Model\AggregateName;
use App\Framework\Domain\Model\Event\AggregateEvent;
use App\Framework\Domain\Model\Event\AggregateEventFactory;
use App\Framework\Domain\Model\EventStreamPointer;
use App\Framework\Domain\Repository\EventStore;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;

use function count;

abstract readonly class PostgresEventStore implements EventStore
{
    final public function __construct(
        private Connection $connection,
        private AggregateEventFactory $aggregateEventFactory,
        private string $domain,
    ) {
    }

    public function store(AggregateEvents $events): void
    {
        $sql = <<<SQL
            INSERT INTO {$this->domain}.event_store
                (aggregate_name, aggregate_id, aggregate_version, event_name, event_data)
            VALUES
                (:aggregate_name, :aggregate_id, :aggregate_version, :event_name, :event_data);
        SQL;

        $statement = $this->connection->prepare($sql);

        /** @var AggregateEvent $event */
        foreach ($events as $event) {
            $statement->bindValue('aggregate_name', $event->getAggregateName()->toString());
            $statement->bindValue('aggregate_id', $event->getAggregateId()->toString());
            $statement->bindValue('aggregate_version', $event->getAggregateVersion()->toInt(), ParameterType::INTEGER);
            $statement->bindValue('event_name', $event->getEventName());
            $statement->bindValue('event_data', $event->serialize());

            $statement->executeStatement();
        }
    }

    public function get(AggregateName $name, AggregateId $id): AggregateEvents
    {
        $sql = <<<SQL
            SELECT
                event_store.event_name,
                event_store.event_data
            FROM
                {$this->domain}.event_store
            WHERE
                event_store.aggregate_name = :aggregate_name
                AND event_store.aggregate_id = :aggregate_id
            ORDER BY
                event_store.aggregate_version ASC;
        SQL;

        $statement = $this->connection->prepare($sql);
        $statement->bindValue('aggregate_name', $name->toString());
        $statement->bindValue('aggregate_id', $id->toString());

        /** @var array<int, array{event_name: string, event_data: string}> $results */
        $results = $statement->executeQuery()->fetchAllAssociative();

        return array_reduce(
            $results,
            fn (AggregateEvents $events, array $event) => $events->add(
                $this->aggregateEventFactory->fromSerialized(
                    $event['event_name'],
                    $event['event_data'],
                ),
            ),
            AggregateEvents::fromNew(),
        );
    }

    public function stream(EventStreamPointer $start, int $limit): AggregateEventsStream
    {
        $end = $this->findEndPointer($start, $limit);

        if ($end === null) {
            return new AggregateEventsStream(next: $start, events: AggregateEvents::fromNew());
        }

        $sql = <<<SQL
            SELECT
                event_store.id,
                event_store.transaction_id,
                event_store.event_name,
                event_store.event_data
            FROM
                {$this->domain}.event_store
            WHERE
                event_store.transaction_id >= :start
                AND event_store.transaction_id <= :end
            ORDER BY
                event_store.transaction_id ASC,
                event_store.id ASC;
        SQL;

        $statement = $this->connection->prepare($sql);

        // start and end are XID8, not an INTEGER.
        $statement->bindValue('start', (string) $start->position);
        $statement->bindValue('end', (string) $end->position);

        /** @var array<int, array{id: int, transaction_id: string, event_name: string, event_data: string}> $results */
        $results = $statement->executeQuery()->fetchAllAssociative();

        $lastTransactionId = count($results) === 0 ? null : $results[array_key_last($results)]['transaction_id'];

        return new AggregateEventsStream(
            next: $lastTransactionId === null ? $start : EventStreamPointer::fromInt((int) $lastTransactionId + 1),
            events: array_reduce(
                $results,
                fn (AggregateEvents $events, array $event) => $events->add(
                    $this->aggregateEventFactory->fromSerialized(
                        $event['event_name'],
                        $event['event_data'],
                    ),
                ),
                AggregateEvents::fromNew(),
            ),
        );
    }

    private function findEndPointer(EventStreamPointer $start, int $limit): ?EventStreamPointer
    {
        $sql = <<<SQL
            SELECT
                MAX(bounded.transaction_id)
            FROM (
                SELECT DISTINCT
                    event_store.transaction_id
                FROM
                    {$this->domain}.event_store
                WHERE
                    event_store.transaction_id >= :start
                    AND event_store.transaction_id < pg_snapshot_xmin(pg_current_snapshot())
                ORDER BY
                    event_store.transaction_id ASC
                LIMIT :limit
            ) bounded;
        SQL;

        $statement = $this->connection->prepare($sql);

        // start is a XID8, not an INTEGER.
        $statement->bindValue('start', (string) $start->position);
        $statement->bindValue('limit', $limit, ParameterType::INTEGER);

        /** @var string|int|false|null $end */
        $end = $statement->executeQuery()->fetchOne();

        if ($end === false || $end === null) {
            return null;
        }

        return EventStreamPointer::fromInt((int) $end);
    }
}
