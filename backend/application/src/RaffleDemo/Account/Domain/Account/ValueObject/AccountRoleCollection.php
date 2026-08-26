<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Account\ValueObject;

use App\Framework\Domain\ValueObject\AbstractCollection;

use function array_map;

/**
 * @extends AbstractCollection<AccountRole>
 */
final readonly class AccountRoleCollection extends AbstractCollection
{
    public static function fromRoles(AccountRole ...$roles): self
    {
        return self::fromItems(...$roles);
    }

    /** @param string[] $values */
    public static function deserialize(array $values): self
    {
        return self::fromItems(...array_map(static fn (string $value): AccountRole => AccountRole::from($value), $values));
    }

    /** @return string[] */
    public function serialize(): array
    {
        return array_map(static fn (AccountRole $role): string => $role->value, $this->toArray());
    }
}
