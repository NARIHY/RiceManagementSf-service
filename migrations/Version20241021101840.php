<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241021101840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bag_stock (bag_id INT NOT NULL, stock_id INT NOT NULL, INDEX IDX_B600749D6F5D8297 (bag_id), INDEX IDX_B600749DDCD6110 (stock_id), PRIMARY KEY(bag_id, stock_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bag_stock ADD CONSTRAINT FK_B600749D6F5D8297 FOREIGN KEY (bag_id) REFERENCES bag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bag_stock ADD CONSTRAINT FK_B600749DDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bag_stock DROP FOREIGN KEY FK_B600749D6F5D8297');
        $this->addSql('ALTER TABLE bag_stock DROP FOREIGN KEY FK_B600749DDCD6110');
        $this->addSql('DROP TABLE bag_stock');
    }
}
