<?php

declare(strict_types=1);

namespace App\Framework\Domain\Model;

use App\Framework\Domain\Model\Event\AggregateEvent;
use Generator;
use IteratorAggregate;

use function array_values;
use function count;

/**
 * @implements IteratorAggregate<int, AggregateEvent>
 */
final readonly class AggregateEvents implements IteratorAggregate
{
    /** @var AggregateEvent[] */
    private array $events;

    private function __construct(
        AggregateEvent ...$events,
    ) {
        $this->events = $events;
    }

    public function add(AggregateEvent $event): self
    {
        return new self(...[...$this->events, $event]);
    }

    public static function fromNew(): self
    {
        return new self();
    }

    public function count(): int
    {
        return count($this->events);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /** @return AggregateEvent[] */
    public function toArray(): array
    {
        return $this->events;
    }

    /** @return Generator<int, AggregateEvent> */
    public function getIterator(): Generator
    {
        yield from array_values($this->events);
    }
}
