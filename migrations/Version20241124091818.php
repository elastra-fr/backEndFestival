<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241124091818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE news (news_id INT AUTO_INCREMENT NOT NULL, news_category_id INT NOT NULL, news_title VARCHAR(255) NOT NULL, news_content VARCHAR(600) NOT NULL, news_date DATETIME NOT NULL, INDEX IDX_1DD399503B732BAD (news_category_id), PRIMARY KEY(news_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_category (news_category_id INT AUTO_INCREMENT NOT NULL, news_category_name VARCHAR(100) NOT NULL, PRIMARY KEY(news_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399503B732BAD FOREIGN KEY (news_category_id) REFERENCES news_category (news_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD399503B732BAD');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE news_category');
    }
}
