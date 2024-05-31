<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240531232052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE band (id INT AUTO_INCREMENT NOT NULL, music_style_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, url_image VARCHAR(255) NOT NULL, INDEX IDX_48DFA2EB7DDE3C52 (music_style_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE band ADD CONSTRAINT FK_48DFA2EB7DDE3C52 FOREIGN KEY (music_style_id) REFERENCES music_style (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE band DROP FOREIGN KEY FK_48DFA2EB7DDE3C52');
        $this->addSql('DROP TABLE band');
    }
}
