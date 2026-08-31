<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Infrastructure\Postgres\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260831114121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds Account Token';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE account.token (
                id UUID PRIMARY KEY,
                account_id UUID NOT NULL,
                context VARCHAR NOT NULL,
                is_global_selector BOOLEAN NOT NULL,
                is_account_selector BOOLEAN NOT NULL,
                selector VARCHAR NOT NULL,
                verifier VARCHAR NOT NULL,
                created_at TIMESTAMPTZ NOT NULL,
                updated_at TIMESTAMPTZ NULL,
                expires_at TIMESTAMPTZ NULL
            );
        ');

        $this->addSql('
            CREATE INDEX token_account_id_context
            ON account.token (account_id, context)
        ');

        $this->addSql('
            CREATE UNIQUE INDEX token_selector_global_unique
            ON account.token (selector)
            WHERE is_global_selector
        ');

        $this->addSql('
            CREATE UNIQUE INDEX token_selector_account_unique
            ON account.token (account_id, context, selector)
            WHERE is_account_selector
        ');
    }
}
