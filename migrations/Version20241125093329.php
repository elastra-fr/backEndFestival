<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125093329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partner (partner_id INT AUTO_INCREMENT NOT NULL, partner_category_id INT NOT NULL, partner_name VARCHAR(255) NOT NULL, partner_logo VARCHAR(255) DEFAULT NULL, partner_description VARCHAR(255) DEFAULT NULL, INDEX IDX_312B3E165B352BAC (partner_category_id), PRIMARY KEY(partner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner_category (partner_category_id INT AUTO_INCREMENT NOT NULL, partner_category VARCHAR(255) NOT NULL, PRIMARY KEY(partner_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E165B352BAC FOREIGN KEY (partner_category_id) REFERENCES partner_category (partner_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E165B352BAC');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE partner_category');
    }
}
