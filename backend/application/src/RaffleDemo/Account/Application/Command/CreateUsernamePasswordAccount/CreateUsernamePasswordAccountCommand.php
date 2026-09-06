<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Application\Command\CreateUsernamePasswordAccount;

use App\Framework\Application\Command\AbstractCommand;
use App\RaffleDemo\Account\Domain\Account\Model\AccountAggregateId;
use App\RaffleDemo\Account\Domain\PersonalData\ValueObject\EmailAddress;
use App\RaffleDemo\Account\Domain\PersonalData\ValueObject\FirstName;
use App\RaffleDemo\Account\Domain\PersonalData\ValueObject\LastName;
use App\RaffleDemo\Account\Domain\Token\ValueObject\UsernamePassword\HashedPassword;
use App\RaffleDemo\Account\Domain\Token\ValueObject\UsernamePassword\Username;

final readonly class CreateUsernamePasswordAccountCommand extends AbstractCommand
{
    private function __construct(
        public AccountAggregateId $id,
        public FirstName $firstName,
        public LastName $lastName,
        public EmailAddress $emailAddress,
        public Username $username,
        public HashedPassword $hashedPassword,
        string $correlationId,
        string $causationId,
        string $dispatchedBy,
    ) {
        parent::__construct($correlationId, $causationId, $dispatchedBy);
    }

    public static function create(
        string $firstName,
        string $lastName,
        string $emailAddress,
        string $hashedPassword,
        string $correlationId,
        ?string $causationId = null,
        ?string $dispatchedBy = null,
    ): self {
        return new self(
            $accountId = AccountAggregateId::fromNew(),
            FirstName::fromString($firstName),
            LastName::fromString($lastName),
            EmailAddress::fromString($emailAddress),
            Username::fromString($emailAddress),
            HashedPassword::fromString($hashedPassword),
            correlationId: $correlationId,
            causationId: $causationId ?? $correlationId,
            dispatchedBy: $dispatchedBy ?? $accountId->toString(),
        );
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id->toString(),
            'firstName' => $this->firstName->toString(),
            'lastName' => $this->lastName->toString(),
            'emailAddress' => $this->emailAddress->toString(),
            'username' => $this->username->toString(),
            'hashedPassword' => $this->hashedPassword->toString(),
        ];
    }
}
