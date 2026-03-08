<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260308204651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add authentication fields to user (password) and roles with empty default';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE users ADD roles JSON NOT NULL DEFAULT '[]'");
        $this->addSql('ALTER TABLE users ADD password VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ALTER external_id DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP roles');
        $this->addSql('ALTER TABLE users DROP password');
        $this->addSql('ALTER TABLE users ALTER external_id SET NOT NULL');
    }
}
