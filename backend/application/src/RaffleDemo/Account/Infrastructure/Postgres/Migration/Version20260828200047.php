<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Infrastructure\Postgres\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260828200047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds Account Personal Data';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE account.personal_data (
                id UUID PRIMARY KEY,
                version INT NOT NULL,
                account_id UUID NOT NULL,
                first_name VARCHAR NOT NULL,
                last_name VARCHAR NOT NULL,
                email_address VARCHAR NOT NULL,
                created_at TIMESTAMPTZ NOT NULL,
                UNIQUE (account_id, version)
            );
        ');

        $this->addSql('
            CREATE INDEX personal_data_account_id_version
            ON account.personal_data (account_id, version DESC)
        ');
    }
}
