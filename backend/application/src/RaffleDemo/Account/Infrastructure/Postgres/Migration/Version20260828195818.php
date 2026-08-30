<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Infrastructure\Postgres\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260828195818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds account event store';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE account.event_store (
                id BIGSERIAL PRIMARY KEY,
                transaction_id XID8 NOT NULL DEFAULT pg_current_xact_id(),
                aggregate_name VARCHAR NOT NULL,
                aggregate_id UUID NOT NULL,
                aggregate_version INT NOT NULL,
                event_name VARCHAR NOT NULL,
                event_data JSONB NOT NULL,
                UNIQUE (aggregate_name, aggregate_id, aggregate_version)
            );
        ');

        $this->addSql('
            CREATE INDEX event_store_transaction_id
                ON account.event_store (transaction_id)
        ');

        $this->addSql('
            CREATE INDEX event_store_aggregate_name_aggregate_id
                ON account.event_store (aggregate_name, aggregate_id)
        ');
    }
}
