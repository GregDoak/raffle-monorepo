<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\PersonalData\Model;

use App\RaffleDemo\Account\Domain\Account\Model\AccountAggregateId;
use App\RaffleDemo\Account\Domain\PersonalData\ValueObject\CreatedAt;
use App\RaffleDemo\Account\Domain\PersonalData\ValueObject\EmailAddress;
use App\RaffleDemo\Account\Domain\PersonalData\ValueObject\FirstName;
use App\RaffleDemo\Account\Domain\PersonalData\ValueObject\LastName;

final readonly class PersonalData
{
    private function __construct(
        public PersonalDataAggregateId $id,
        public PersonalDataAggregateVersion $version,
        public AccountAggregateId $accountId,
        public FirstName $firstName,
        public LastName $lastName,
        public EmailAddress $emailAddress,
        public CreatedAt $createdAt,
    ) {
    }

    public static function fromNew(
        AccountAggregateId $accountId,
        FirstName $firstName,
        LastName $lastName,
        EmailAddress $emailAddress,
    ): self {
        return new self(
            id: PersonalDataAggregateId::fromNew(),
            version: PersonalDataAggregateVersion::fromNew(),
            accountId: $accountId,
            firstName: $firstName,
            lastName: $lastName,
            emailAddress: $emailAddress,
            createdAt: CreatedAt::fromNew(),
        );
    }

    public static function fromAnonymized(
        PersonalDataAggregateId $id,
        PersonalDataAggregateVersion $version,
        AccountAggregateId $accountId,
    ): self {
        return new self(
            id: $id,
            version: $version,
            accountId: $accountId,
            firstName: FirstName::fromAnonymized(),
            lastName: LastName::fromAnonymized(),
            emailAddress: EmailAddress::fromAnonymized(),
            createdAt: CreatedAt::fromNew(),
        );
    }
}
