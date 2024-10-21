<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241021092548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660E9C84D80');
        $this->addSql('DROP INDEX UNIQ_4B365660E9C84D80 ON stock');
        $this->addSql('ALTER TABLE stock DROP arrivals_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock ADD arrivals_id INT NOT NULL');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660E9C84D80 FOREIGN KEY (arrivals_id) REFERENCES arrival (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4B365660E9C84D80 ON stock (arrivals_id)');
    }
}
