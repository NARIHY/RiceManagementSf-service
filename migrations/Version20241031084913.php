<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241031084913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD gender_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455708A0E0 FOREIGN KEY (gender_id) REFERENCES gender_management (id)');
        $this->addSql('CREATE INDEX IDX_C7440455708A0E0 ON client (gender_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455708A0E0');
        $this->addSql('DROP INDEX IDX_C7440455708A0E0 ON client');
        $this->addSql('ALTER TABLE client DROP gender_id');
    }
}
