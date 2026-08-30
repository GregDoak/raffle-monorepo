<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Infrastructure\Postgres\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260828195400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates Account schema';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA account');
    }
}
