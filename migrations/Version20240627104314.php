<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627104314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercitii (id INT AUTO_INCREMENT NOT NULL, tip_id_id INT NOT NULL, nume VARCHAR(255) NOT NULL, link_video VARCHAR(255) NOT NULL, INDEX IDX_5B39E9622C343EA4 (tip_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercitii ADD CONSTRAINT FK_5B39E9622C343EA4 FOREIGN KEY (tip_id_id) REFERENCES tip (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercitii DROP FOREIGN KEY FK_5B39E9622C343EA4');
        $this->addSql('DROP TABLE exercitii');
    }
}
