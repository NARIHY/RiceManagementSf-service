<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241014120730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arrival (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, label_name VARCHAR(255) NOT NULL, arrival_date DATETIME NOT NULL, bag_price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5BE55CB46BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE arrival_type_rice (arrival_id INT NOT NULL, type_rice_id INT NOT NULL, INDEX IDX_B776816B62789708 (arrival_id), INDEX IDX_B776816BAA2B3995 (type_rice_id), PRIMARY KEY(arrival_id, type_rice_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE arrival ADD CONSTRAINT FK_5BE55CB46BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE arrival_type_rice ADD CONSTRAINT FK_B776816B62789708 FOREIGN KEY (arrival_id) REFERENCES arrival (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE arrival_type_rice ADD CONSTRAINT FK_B776816BAA2B3995 FOREIGN KEY (type_rice_id) REFERENCES type_rice (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrival DROP FOREIGN KEY FK_5BE55CB46BF700BD');
        $this->addSql('ALTER TABLE arrival_type_rice DROP FOREIGN KEY FK_B776816B62789708');
        $this->addSql('ALTER TABLE arrival_type_rice DROP FOREIGN KEY FK_B776816BAA2B3995');
        $this->addSql('DROP TABLE arrival');
        $this->addSql('DROP TABLE arrival_type_rice');
    }
}
