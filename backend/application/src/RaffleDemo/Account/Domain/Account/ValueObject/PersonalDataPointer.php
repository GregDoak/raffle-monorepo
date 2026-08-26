<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Account\ValueObject;

use App\RaffleDemo\Account\Domain\PersonalData\Model\PersonalDataAggregateId;
use App\RaffleDemo\Account\Domain\PersonalData\Model\PersonalDataAggregateVersion;

final readonly class PersonalDataPointer
{
    public function __construct(
        public PersonalDataAggregateId $id,
        public PersonalDataAggregateVersion $version,
    ) {
    }

    public function equals(self $that): bool
    {
        return $this->id->equals($that->id) && $this->version->equals($that->version);
    }

    /**
     * @return array{
     *     id: string,
     *     version: int,
     * }
     */
    public function serialize(): array
    {
        return [
            'id' => $this->id->toString(),
            'version' => $this->version->toInt(),
        ];
    }

    /**
     * @param array{
     *     id: string,
     *     version: int,
     * } $data
     */
    public static function deserialize(array $data): self
    {
        return new self(
            id: PersonalDataAggregateId::fromString($data['id']),
            version: PersonalDataAggregateVersion::fromInt($data['version']),
        );
    }
}
