<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Infrastructure\Postgres\Repository;

use App\Framework\Domain\Exception\AggregateNotFound;
use App\RaffleDemo\Account\Domain\PersonalData\Model\PersonalData;
use App\RaffleDemo\Account\Domain\PersonalData\Model\PersonalDataAggregateId;
use App\RaffleDemo\Account\Domain\PersonalData\Model\PersonalDataAggregateName;
use App\RaffleDemo\Account\Domain\PersonalData\Repository\PersonalDataRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;

final readonly class PostgresPersonalDataRepository implements PersonalDataRepository
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function store(PersonalData $personalData): void
    {
        $sql = <<<SQL
            INSERT INTO account.personal_data
                (id, version, account_id, first_name, last_name, email_address, created_at)
            VALUES
                (:id, :version, :account_id, :first_name, :last_name, :email_address, :created_at)
        SQL;

        $statement = $this->connection->prepare($sql);

        $statement->bindValue('id', $personalData->id->toString());
        $statement->bindValue('version', $personalData->version->toInt(), ParameterType::INTEGER);
        $statement->bindValue('account_id', $personalData->accountId->toString());
        $statement->bindValue('first_name', $personalData->firstName->toString());
        $statement->bindValue('last_name', $personalData->lastName->toString());
        $statement->bindValue('email_address', $personalData->emailAddress->toString());
        $statement->bindValue('created_at', $personalData->createdAt->toString());

        $statement->executeStatement();
    }

    public function getById(PersonalDataAggregateId $id): PersonalData
    {
        $sql = <<<SQL
            SELECT
                id,
                version,
                account_id,
                first_name,
                last_name,
                email_address,
                created_at
            FROM
                account.personal_data
            WHERE
                personal_data.id = :id
        SQL;

        $statement = $this->connection->prepare($sql);

        $statement->bindValue('id', $id);

        $record = $statement->executeQuery()->fetchAssociative();

        if ($record === false) {
            throw AggregateNotFound::fromAggregateNameAndAggregateId(PersonalDataAggregateName::create(), $id);
        }

        return PersonalData::fromArray($record); // @phpstan-ignore-line argument.type
    }
}
