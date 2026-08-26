<?php

declare(strict_types=1);

namespace App\Framework\Domain\ValueObject;

use Generator;
use IteratorAggregate;

use function array_values;
use function count;
use function in_array;

/**
 * @template T
 * @implements IteratorAggregate<int, T>
 * @phpstan-consistent-constructor
 */
abstract readonly class AbstractCollection implements IteratorAggregate
{
    /** @var T[] */
    private array $items;

    /** @param T ...$items */
    protected function __construct(
        mixed ...$items,
    ) {
        $this->items = $items;
    }

    /** @param T ...$items */
    public static function fromItems(mixed ...$items): static
    {
        return new static(...$items);
    }

    /** @param T $item */
    public function add(mixed $item): static
    {
        return new static(...[...$this->items, $item]);
    }

    /** @param T $item */
    public function contains(mixed $item): bool
    {
        return in_array($item, $this->items, true);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /** @return T[] */
    public function toArray(): array
    {
        return $this->items;
    }

    /** @return Generator<int, T> */
    public function getIterator(): Generator
    {
        yield from array_values($this->items);
    }
}
