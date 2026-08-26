<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Application\Command\CreateUsernamePasswordAccount;

use App\Framework\Application\Command\AbstractCommand;
use App\RaffleDemo\Account\Domain\Account\Model\AccountAggregateId;
use App\RaffleDemo\Account\Domain\PersonalData\ValueObject\EmailAddress;
use App\RaffleDemo\Account\Domain\PersonalData\ValueObject\FirstName;
use App\RaffleDemo\Account\Domain\PersonalData\ValueObject\LastName;

final readonly class CreateUsernamePasswordAccountCommand extends AbstractCommand
{
    private function __construct(
        public AccountAggregateId $id,
        public FirstName $firstName,
        public LastName $lastName,
        public EmailAddress $emailAddress,
        private string $correlationId,
        private string $causationId,
    ) {
        parent::__construct(
            $this->correlationId,
            $this->causationId,
        );
    }

    public static function create(
        string $firstName,
        string $lastName,
        string $emailAddress,
        string $correlationId,
    ): self {
        return new self(
            AccountAggregateId::fromNew(),
            FirstName::fromString($firstName),
            LastName::fromString($lastName),
            EmailAddress::fromString($emailAddress),
            correlationId: $correlationId,
            causationId: $correlationId,
        );
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id->toString(),
            'firstName' => $this->firstName->toString(),
            'lastName' => $this->lastName->toString(),
            'emailAddress' => $this->emailAddress->toString(),
        ];
    }
}
