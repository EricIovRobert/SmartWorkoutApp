<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627104830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercise_log (id INT AUTO_INCREMENT NOT NULL, workout_id_id INT NOT NULL, exercise_id_id INT NOT NULL, nr_reps INT NOT NULL, durata TIME NOT NULL, INDEX IDX_1960CDB9268F2D43 (workout_id_id), INDEX IDX_1960CDB95A726995 (exercise_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercise_log ADD CONSTRAINT FK_1960CDB9268F2D43 FOREIGN KEY (workout_id_id) REFERENCES workout (id)');
        $this->addSql('ALTER TABLE exercise_log ADD CONSTRAINT FK_1960CDB95A726995 FOREIGN KEY (exercise_id_id) REFERENCES exercitii (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise_log DROP FOREIGN KEY FK_1960CDB9268F2D43');
        $this->addSql('ALTER TABLE exercise_log DROP FOREIGN KEY FK_1960CDB95A726995');
        $this->addSql('DROP TABLE exercise_log');
    }
}
