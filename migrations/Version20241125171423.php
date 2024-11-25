<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125171423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE faq_category (faq_category_id INT AUTO_INCREMENT NOT NULL, faq_category VARCHAR(255) NOT NULL, PRIMARY KEY(faq_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq_content (faq_content_id INT AUTO_INCREMENT NOT NULL, faq_category_id INT NOT NULL, faq_content_title VARCHAR(255) NOT NULL, faq_content_details VARCHAR(500) NOT NULL, content_update DATETIME NOT NULL, INDEX IDX_E5B45BF2F689B0DB (faq_category_id), PRIMARY KEY(faq_content_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE faq_content ADD CONSTRAINT FK_E5B45BF2F689B0DB FOREIGN KEY (faq_category_id) REFERENCES faq_category (faq_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faq_content DROP FOREIGN KEY FK_E5B45BF2F689B0DB');
        $this->addSql('DROP TABLE faq_category');
        $this->addSql('DROP TABLE faq_content');
    }
}
