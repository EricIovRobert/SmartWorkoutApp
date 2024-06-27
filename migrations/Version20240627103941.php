<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627103941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE workout (id INT AUTO_INCREMENT NOT NULL, tip_id_id INT NOT NULL, user_id_id INT NOT NULL, nume VARCHAR(255) NOT NULL, data DATE NOT NULL, INDEX IDX_649FFB722C343EA4 (tip_id_id), INDEX IDX_649FFB729D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB722C343EA4 FOREIGN KEY (tip_id_id) REFERENCES tip (id)');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB729D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workout DROP FOREIGN KEY FK_649FFB722C343EA4');
        $this->addSql('ALTER TABLE workout DROP FOREIGN KEY FK_649FFB729D86650F');
        $this->addSql('DROP TABLE workout');
    }
}
