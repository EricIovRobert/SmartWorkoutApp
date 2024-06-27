<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627102407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE super (id INT AUTO_INCREMENT NOT NULL, legatura_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_D6C1DA0EF88461CE (legatura_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE super ADD CONSTRAINT FK_D6C1DA0EF88461CE FOREIGN KEY (legatura_id) REFERENCES test (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE super DROP FOREIGN KEY FK_D6C1DA0EF88461CE');
        $this->addSql('DROP TABLE super');
    }
}
