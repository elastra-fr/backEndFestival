<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602190943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE faq_content (id INT AUTO_INCREMENT NOT NULL, section_id INT NOT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(500) NOT NULL, content_update DATETIME NOT NULL, INDEX IDX_E5B45BF2D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE faq_content ADD CONSTRAINT FK_E5B45BF2D823E37A FOREIGN KEY (section_id) REFERENCES faq_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faq_content DROP FOREIGN KEY FK_E5B45BF2D823E37A');
        $this->addSql('DROP TABLE faq_content');
    }
}
