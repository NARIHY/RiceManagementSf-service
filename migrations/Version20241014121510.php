<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241014121510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bag (id INT AUTO_INCREMENT NOT NULL, quantity BIGINT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE arrival ADD bag_id INT NOT NULL');
        $this->addSql('ALTER TABLE arrival ADD CONSTRAINT FK_5BE55CB46F5D8297 FOREIGN KEY (bag_id) REFERENCES bag (id)');
        $this->addSql('CREATE INDEX IDX_5BE55CB46F5D8297 ON arrival (bag_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrival DROP FOREIGN KEY FK_5BE55CB46F5D8297');
        $this->addSql('DROP TABLE bag');
        $this->addSql('DROP INDEX IDX_5BE55CB46F5D8297 ON arrival');
        $this->addSql('ALTER TABLE arrival DROP bag_id');
    }
}
