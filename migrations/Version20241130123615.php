<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241130123615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bag_stock (bag_id INT NOT NULL, stock_id INT NOT NULL, INDEX IDX_B600749D6F5D8297 (bag_id), INDEX IDX_B600749DDCD6110 (stock_id), PRIMARY KEY(bag_id, stock_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cin (id INT AUTO_INCREMENT NOT NULL, location_zone VARCHAR(255) NOT NULL, location_region VARCHAR(255) DEFAULT NULL, location_province VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, creation_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique_temp (id INT AUTO_INCREMENT NOT NULL, nom_table VARCHAR(255) DEFAULT NULL, action VARCHAR(10) DEFAULT NULL, details LONGTEXT DEFAULT NULL, date_action DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE token_blacklist (id INT AUTO_INCREMENT NOT NULL, token LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bag_stock ADD CONSTRAINT FK_B600749D6F5D8297 FOREIGN KEY (bag_id) REFERENCES bag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bag_stock ADD CONSTRAINT FK_B600749DDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client ADD gender_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, ADD cin_provenance_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455708A0E0 FOREIGN KEY (gender_id) REFERENCES gender_management (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404551E46E1CA FOREIGN KEY (cin_provenance_id) REFERENCES cin (id)');
        $this->addSql('CREATE INDEX IDX_C7440455708A0E0 ON client (gender_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455A76ED395 ON client (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C74404551E46E1CA ON client (cin_provenance_id)');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660E9C84D80');
        $this->addSql('DROP INDEX UNIQ_4B365660E9C84D80 ON stock');
        $this->addSql('ALTER TABLE stock DROP arrivals_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404551E46E1CA');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A76ED395');
        $this->addSql('ALTER TABLE bag_stock DROP FOREIGN KEY FK_B600749D6F5D8297');
        $this->addSql('ALTER TABLE bag_stock DROP FOREIGN KEY FK_B600749DDCD6110');
        $this->addSql('DROP TABLE bag_stock');
        $this->addSql('DROP TABLE cin');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE historique_temp');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE token_blacklist');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455708A0E0');
        $this->addSql('DROP INDEX IDX_C7440455708A0E0 ON client');
        $this->addSql('DROP INDEX UNIQ_C7440455A76ED395 ON client');
        $this->addSql('DROP INDEX UNIQ_C74404551E46E1CA ON client');
        $this->addSql('ALTER TABLE client DROP gender_id, DROP user_id, DROP cin_provenance_id');
        $this->addSql('ALTER TABLE stock ADD arrivals_id INT NOT NULL');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660E9C84D80 FOREIGN KEY (arrivals_id) REFERENCES arrival (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4B365660E9C84D80 ON stock (arrivals_id)');
    }
}
